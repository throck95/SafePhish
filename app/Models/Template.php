<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 8/4/2016
 * Time: 11:04 AM
 */

namespace App\Models;

use Doctrine\Instantiator\Exception\UnexpectedValueException;
use League\Flysystem\FileExistsException;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';

    protected $fillable = ['TMP_FileName',
        'TMP_Educational',
        'TMP_ComplexityType',
        'TMP_SpecificityType'];

    private static function createNewTemplate($input, $path, $name) {
        if(file_exists("$path/$name.blade.php")) {
            throw new FileExistsException("File already exists.");
        }

        if(self::validateTemplateContent($input)) {
            $content = '';
            $paragraphs = explode(PHP_EOL,$input);

            for($i = 0; $i < sizeof($paragraphs); $i++) {
                $content .= "<p>" . $paragraphs[$i] . "</p>";
            }

            \File::put("$path/$name.blade.php",$content);
            \File::delete('../resources/views/emails/.blade.php');
        } else {
            throw new UnexpectedValueException("Input is not valid. You may not use '<>'. " .
                "Input provided: " . var_export($input));
        }
        
        if(count(self::where('TMP_FileName',$name)->first())) {
            \File::delete("$path/$name.blade.php");
            throw new UnexpectedValueException("DATA DISCREPANCY: File exists according to database.");
        }
        self::create(['TMP_FileName'=>$name,'TMP_Educational'=>0,'TMP_ComplexityType'=>'Advanced','TMP_SpecificityType'=>'Targeted']);
    }

    private static function validateTemplateContent($input) {
        return filter_var(
            $input,
            FILTER_VALIDATE_REGEXP,
            array(
                "options"=>
                    array(
                        "regexp"=>"/([^<>])/"
                    )
            )
        );
    }

    public static function createPhish($input,$name) {
        self::createNewTemplate($input,"../resources/views/emails/phishing",$name);
    }

    public static function createEdu($input,$name) {
        self::createNewTemplate($input,"../resources/views/emails/edu",$name);
    }
}