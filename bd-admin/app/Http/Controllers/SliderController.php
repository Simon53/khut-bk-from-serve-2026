<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    //=========base url ========================
   // public function sliderIndex(){
     //   $sliders = Slider::all(); 
    //    return view('slider.slider', compact('sliders'));
  //  }

  //  public function store(Request $request){
  //  try {
  //      $request->validate([
    //        'slider_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //    ]);

    //    if ($request->hasFile('slider_image')) {
    //        $image = $request->file('slider_image');
    //        $imageName = time().'.'.$image->getClientOriginalExtension();
    //       $image->move(public_path('uploads/sliders'), $imageName);

    //        $slider = new Slider();
    //        $imagePath = 'uploads/sliders/' . $imageName;
    //        $slider->slider_location = url($imagePath); 
    //        $slider->is_active = $request->has('is_active') ? 'Yes' : 'No';
    //        $slider->save();

    //        return response()->json([
    //            'status' => 'success',
    //            'message' => 'Slider uploaded & saved!',
    //        ]);
    //    }

    //    return response()->json([
     //       'status' => 'error',
     //       'message' => 'No file uploaded!',
    //    ], 422);

   // } catch (\Exception $e) {
    //    return response()->json([
    //        'status' => 'error',
    //        'message' => $e->getMessage(),
    //    ], 500);
   // }
//}





    //edit
  //  public function update(Request $request, $id){
    //    try {
      //      $slider = Slider::findOrFail($id);

      //      if ($request->hasFile('slider_image')) {
      //          $image = $request->file('slider_image');
      //          $imageName = time().'.'.$image->getClientOriginalExtension();
      //          $image->move(public_path('uploads/sliders'), $imageName);
      //          $slider->slider_location = 'uploads/sliders/' . $imageName;
      //      }

      //      $slider->is_active = $request->has('is_active') ? 'Yes' : 'No';
       //     $slider->save();

     //       return response()->json([
     //           'status' => 'success',
     //           'message' => 'Slider updated successfully!',
     //           'image_url' => asset($slider->slider_location),
     //       ]);

    //    } catch (\Exception $e) {
     //       return response()->json([
     //           'status' => 'error',
     //           'message' => $e->getMessage(),
     //       ], 500);
     //   }
  //  }




    //delete
  //  public function destroy($id){
   //     try {
      //      $slider = Slider::findOrFail($id);

            // Delete the image from storage (if needed)
     //       if ($slider->slider_location && File::exists(public_path($slider->slider_location))) {
      //          File::delete(public_path($slider->slider_location));
      //      }

      //      $slider->delete();

      //      return response()->json([
      //          'status' => 'success',
       //         'message' => 'Slider deleted successfully.'
       //     ]);
      //  } catch (\Exception $e) {
       //     \Log::error("Slider delete failed: " . $e->getMessage());
        //    return response()->json([
        //        'status' => 'error',
        //        'message' => 'Delete failed: ' . $e->getMessage()
        //    ], 500);
       // }
   // }

//=================================wiuthout base url=============
   public function sliderIndex()
{
    $sliders = Slider::orderBy('id', 'desc')->get();
    return view('slider.slider', compact('sliders'));
}

public function store(Request $request)
{
  //dd(ini_get('open_basedir'));
    
    try {
        $request->validate([
            'slider_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $slider = new Slider();

        if ($request->hasFile('slider_image')) {
            $image = $request->file('slider_image');
            $path = $image->store('sliders', 'public'); 
            // store in storage/app/public/sliders
            $slider->slider_location = $path; // save relative path
        }

        $slider->is_active = $request->has('is_active') ? 'Yes' : 'No';
        $slider->save();
        
         

        return response()->json([
            'status' => 'success',
            'message' => 'Slider uploaded & saved!',
            'slider' => [
                'id' => $slider->id,
                'url' => asset('storage/'.$slider->slider_location),
                'is_active' => $slider->is_active,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
    
   
}

/*public function update(Request $request, $id)
{
    try {
        $slider = Slider::findOrFail($id);

        if ($request->hasFile('slider_image')) {
            // delete old image
            if ($slider->slider_location && Storage::disk('public')->exists($slider->slider_location)) {
                Storage::disk('public')->delete($slider->slider_location);
            }

            $image = $request->file('slider_image');
            $path = $image->store('sliders', 'public');
            $slider->slider_location = $path;
        }

        $slider->is_active = $request->has('is_active') ? 'Yes' : 'No';
        $slider->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Slider updated successfully!',
            'slider' => [
                'id' => $slider->id,
                'url' => asset('storage/'.$slider->slider_location),
                'is_active' => $slider->is_active,
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}*/


public function update(Request $request, $id)
{
    try {
        $slider = Slider::findOrFail($id);

        if ($request->hasFile('slider_image')) {
            // delete old image if exists
            if ($slider->slider_location && Storage::disk('public')->exists($slider->slider_location)) {
                Storage::disk('public')->delete($slider->slider_location);
            }

            $image = $request->file('slider_image');
            $path = $image->store('sliders', 'public'); // storage/app/public/sliders
            $slider->slider_location = $path;
        }

        $slider->is_active = $request->has('is_active') ? 'Yes' : 'No';
        $slider->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Slider updated successfully!',
            'slider' => [
                'id' => $slider->id,
                'url' => asset('storage/'.$slider->slider_location),
                'is_active' => $slider->is_active,
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}



public function destroy($id)
{
    try {
        $slider = Slider::findOrFail($id);

        if ($slider->slider_location && Storage::disk('public')->exists($slider->slider_location)) {
            Storage::disk('public')->delete($slider->slider_location);
        }

        $slider->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Slider deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Delete failed: ' . $e->getMessage()
        ], 500);
    }
}

}




