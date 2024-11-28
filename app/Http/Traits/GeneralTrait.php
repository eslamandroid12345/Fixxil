<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

Trait GeneralTrait
{

    public function upload_file($file,$model)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() .'.'.$extension;
        Storage::disk('public')->put($filename, $model);
        $path = $file->move('storage/'.$model.'/', $filename);
        return $path;
    }

    public function returnError($errNum ,$msg)
    {
      if(empty($errNum))
      {
        $errNum='404';
      }
      return response()->json(['status' => false,'msg' => $msg],$errNum);
    }

    public function returnSuccessMassage($msg ="",$code="200")
    {
      return response()->json(['status' => true,'msg' => $msg],$code);
    }

    public function returnData($key , $value , $msg ="")
    {
      return response()->json(['status' => true,'msg' => $msg ,$key => $value ],200);
    }

    public function returnValidationError($code = "401", $validator)
    {
      return $this->returnError($code, $validator->errors()->first());
    }

    public function upload($requestAttributeName = null, $folder = '', $disk = 'public')
    {
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid())
        {
            $path = 'storage/'.request()->file($requestAttributeName)->store($folder, $disk);
        }
        return $path;
    }

    public function updateFile($requestAttributeName = null, $folder = '',$oldPath)
    {
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid())
        {
            $path = $this->upload($requestAttributeName,$folder);
            if(file_exists($oldPath))
            {
                unlink($oldPath);
            }
        }
        return $path;
    }

    public function deleteFile($oldPath)
    {
        if(file_exists($oldPath))
        {
            unlink($oldPath);
        }
    }

    public function handle($requestAttributeName, $folderName, $target = null)
    {
        $path = $this->upload($requestAttributeName, $folderName);
        if (!is_null($target))
        {
            $this->deleteFile($target);
        }
        return $path;
    }

    public function deleteImage($path)
    {
        File::delete(ltrim(parse_url($path)['path'],'/'));
    }

}

?>
