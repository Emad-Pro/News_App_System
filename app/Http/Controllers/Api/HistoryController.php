<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoryStory;
use App\Http\Resources\HistoryStoryResource;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        // جلب كل القصص وترتيبها من الأقدم للأحدث
        $stories = HistoryStory::orderBy('story_date', 'asc')->get();
        return HistoryStoryResource::collection($stories);
    }
}