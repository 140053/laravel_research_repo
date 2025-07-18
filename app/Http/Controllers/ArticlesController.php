<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'body' => 'required|string',
            'published' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //dd($validated);

        $article = Article::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'body' => $validated['body'],
            'published' => $request->has('published'),
        ]);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('article_images', 'public');
                $article->images()->create([
                    'path' => $path,
                ]);
            }
        }



        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
       // dd($article);
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $article->load('images');
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'published' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $article->update([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'body' => $validated['body'],
            'published' => $request->has('published'),
        ]);

        // Add new uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('article_images', 'public');
                $article->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        // Delete all associated images
        foreach ($article->images as $image) {
            if ($image->path) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }
    
        // Delete the article itself
        $article->delete();
    
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
    

    // Optional: Add this method to delete a specific image (used from edit view)
    public function deleteImage(ArticleImage $image)
    {
        if ($image->path) {
            Storage::disk('public')->delete($image->path);
        }
    
        $image->delete();
    
        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
    

}
