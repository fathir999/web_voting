<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'message' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'candidate_id' => $request->candidate_id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function reset()
    {   
         //karena tidak ada komentar yang di hapus maka akan 
        //muncul pesan tidak ada komentar yang di hapus
         $count = Comment::count();
         // $count ini menghitung total komentar di table
         // kalalu hasil nya 0 yang di komentar atau tidak ada komentar
         //maka akan muncul pesan tidak ada komentar

        if($count === 0){

       
        return redirect()
        ->route('admin.comments.index')
        ->with('info',"tidak ada komentar yang di hapus");
        }


        //comentar yang di hapus
        Comment::truncate();
        return redirect()->route('admin.comments.index')->with('success','Semua komentar berhasil di hapus ');

       
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success','komentar berhasil di hapus.');
     
    }
       

}
