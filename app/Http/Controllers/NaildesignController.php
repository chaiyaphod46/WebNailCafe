<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Naildesign;
use App\Models\Like;

class NaildesignController extends Controller
{
    public function addview(){
        $naildesign = naildesign::all();
        return view('add_naildesign',compact('naildesign'));
    }

    public function upload(Request $request){

        $naildesign = new naildesign;
        $image = $request->file;

        $imagename = time().'.'.$image->getClientoriginalExtension();

        $request->file->move('naildesingimage',$imagename);

        $naildesign->image = $imagename;
        $naildesign->nailname = $request->nailname;
        $naildesign->design_price = $request->design_price;
        $naildesign->design_time = $request->design_time;
        $naildesign->design_type = $request->design_type;

        $naildesign->save();
        
        session()->flash('success', 'บันทึกสำเร็จ');
        return redirect()->back();

    }

    public function deletnaildesign($nail_design_id)
    {
        $naildesign=Naildesign::find($nail_design_id);
        $naildesign->delete();

        session()->flash('success', 'ลบสำเร็จ');
        return redirect()->back();

    }

    public function editnaildesign($nail_design_id)
    {
        $naildesign=Naildesign::find($nail_design_id);

        return view('edit_naildesign',compact('naildesign'));

    }
    public function saveeditnaildesign(Request $request, $nail_design_id)
    {
        $naildesign = Naildesign::find($nail_design_id);
        $naildesign->nailname=$request->nailname;
        $naildesign->design_price = $request->design_price;
        $naildesign->design_time = $request->design_time;
        $naildesign->design_type = $request->design_type;
        
        $image=$request->file;

        if($image)
        {
         $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->file->move('naildesingimage',$imagename);
            $naildesign->image=$imagename;
            
        }
        $naildesign->save();

        session()->flash('success', 'แก้ไขสำเร็จ');
        return redirect()->back();
        

    }

    
    


    
    


}
