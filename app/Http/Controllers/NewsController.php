<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:wartawan')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('role:editor')->only(['approve', 'reject']);
    }

    public function index()
    {
        $news = auth()->user()->isAdmin() 
            ? News::with(['category', 'author'])->latest()->paginate(10)
            : News::where('user_id', auth()->id())->with(['category'])->latest()->paginate(10);

        return view('news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();
        $data['status'] = 'draft';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news-images', 'public');
        }

        News::create($data);

        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        if ($news->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        if ($news->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news-images', 'public');
        }

        $news->update($data);

        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted successfully.');
    }

    public function approve(News $news)
    {
        $news->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
            'published_at' => now()
        ]);

        return redirect()->back()->with('success', 'News approved and published successfully.');
    }

    public function reject(News $news)
    {
        $news->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'News rejected successfully.');
    }
} 