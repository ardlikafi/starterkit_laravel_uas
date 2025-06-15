@extends('adminlte::page')

@section('title', $news->title)

@section('content_header')
    <h1>{{ $news->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3>Content</h3>
                    <div class="content">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">News Details</h3>
                        </div>
                        <div class="card-body">
                            <dl>
                                <dt>Category</dt>
                                <dd>{{ $news->category->name }}</dd>

                                <dt>Author</dt>
                                <dd>{{ $news->author->name }}</dd>

                                <dt>Status</dt>
                                <dd>
                                    <span class="badge badge-{{ $news->status === 'published' ? 'success' : ($news->status === 'draft' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($news->status) }}
                                    </span>
                                </dd>

                                <dt>Created At</dt>
                                <dd>{{ $news->created_at->format('Y-m-d H:i') }}</dd>

                                @if($news->status === 'published')
                                    <dt>Published At</dt>
                                    <dd>{{ $news->published_at->format('Y-m-d H:i') }}</dd>

                                    <dt>Approved By</dt>
                                    <dd>{{ $news->approver->name }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>

                    @if($news->image)
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Image</h3>
                            </div>
                            <div class="card-body">
                                <img src="{{ Storage::url($news->image) }}" alt="News Image" class="img-fluid">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('news.index') }}" class="btn btn-secondary">Back to List</a>
            @if($news->user_id === auth()->id() || auth()->user()->isAdmin())
                <a href="{{ route('news.edit', $news) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('news.destroy', $news) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            @endif
            @if(auth()->user()->isEditor() && $news->status === 'draft')
                <form action="{{ route('news.approve', $news) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
                <form action="{{ route('news.reject', $news) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            @endif
        </div>
    </div>
@stop 