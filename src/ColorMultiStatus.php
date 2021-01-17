<?php

namespace Jankapusta\NovaColorMultiStatusField;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class ColorMultiStatus
 * @package Jankapusta\NovaColorMultiStatusField
 *
 *
 */
class ColorMultiStatus extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-color-multi-status-field';


    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = json_decode($request[$requestAttribute], true);
        }
    }

    /**
     * @param bool $value
     * @return ColorMultiStatus
     */
    public function showTooltips($value = true)
    {
        return $this->withMeta([
            'showTooltips' => $value,
        ]);
    }

    /**
     * To set total width in pixels
     *
     * @param $value
     * @return ColorMultiStatus
     */
    public function width($value)
    {
        return $this->withMeta([
            'width' => $value,
        ]);
    }

    /**
     * To set an icon width/height in pixels
     *
     * @param $value
     * @return ColorMultiStatus
     */
    public function iconSize($value)
    {
        return $this->withMeta([
            'iconSize' => $value,
        ]);
    }

    /**
     * To set an icon margin in pixels
     *
     * @param $value
     * @return ColorMultiStatus
     */
    public function iconSpacing($value)
    {
        return $this->withMeta([
            'iconSpacing' => $value,
        ]);
    }

    /**
     * @param $map
     * @param $autoFillFullRange
     * @return ColorMultiStatus
     * @throws ValidationException
     */
    public function colorMap($map)
    {
        if (!is_array($map) && !($map instanceof Collection) || collect($map)->isEmpty()) {
            throw new ValidationException('Color map must have at least 1 value (indexed array or collection)');
        }
        $asCollection = collect($map);
        return $this->withMeta([
            'colorMap' => $asCollection->toArray(),
        ]);
    }

    // TODO make auto range calculation (gradient)

//    public function gradient($from_color, $to_color, $graduations = 10) {
//        $graduations--;
//        $startcol = str_replace("#", "", $from_color);
//        $endcol = str_replace("#", "", $to_color);
//        $RedOrigin = hexdec(substr($startcol, 0, 2));
//        $GrnOrigin = hexdec(substr($startcol, 2, 2));
//        $BluOrigin = hexdec(substr($startcol, 4, 2));
//        if ($graduations >= 2) { // for at least 3 colors
//            $GradientSizeRed = (hexdec(substr($endcol, 0, 2)) - $RedOrigin) / $graduations; //Graduation Size Red
//            $GradientSizeGrn = (hexdec(substr($endcol, 2, 2)) - $GrnOrigin) / $graduations;
//            $GradientSizeBlu = (hexdec(substr($endcol, 4, 2)) - $BluOrigin) / $graduations;
//            for ($i = 0; $i <= $graduations; $i++) {
//                $RetVal[$i] = strtoupper("#" . str_pad(dechex($RedOrigin + ($GradientSizeRed * $i)), 2, '0', STR_PAD_LEFT) .
//                    str_pad(dechex($GrnOrigin + ($GradientSizeGrn * $i)), 2, '0', STR_PAD_LEFT) .
//                    str_pad(dechex($BluOrigin + ($GradientSizeBlu * $i)), 2, '0', STR_PAD_LEFT));
//            }
//        } elseif ($graduations == 1) { // exactlly 2 colors
//            $RetVal[] = $from_color;
//            $RetVal[] = $to_color;
//        } else { // one color
//            $RetVal[] = $from_color;
//        }
//        return $RetVal;
//    }
//
//    public function color_name_to_hex($color_name)
//    {
//        // standard 147 HTML color names
//        $colors  =  array(
//            'aliceblue'=>'F0F8FF',
//            'antiquewhite'=>'FAEBD7',
//            'aqua'=>'00FFFF',
//            'aquamarine'=>'7FFFD4',
//            'azure'=>'F0FFFF',
//            'beige'=>'F5F5DC',
//            'bisque'=>'FFE4C4',
//            'black'=>'000000',
//            'blanchedalmond '=>'FFEBCD',
//            'blue'=>'0000FF',
//            'blueviolet'=>'8A2BE2',
//            'brown'=>'A52A2A',
//            'burlywood'=>'DEB887',
//            'cadetblue'=>'5F9EA0',
//            'chartreuse'=>'7FFF00',
//            'chocolate'=>'D2691E',
//            'coral'=>'FF7F50',
//            'cornflowerblue'=>'6495ED',
//            'cornsilk'=>'FFF8DC',
//            'crimson'=>'DC143C',
//            'cyan'=>'00FFFF',
//            'darkblue'=>'00008B',
//            'darkcyan'=>'008B8B',
//            'darkgoldenrod'=>'B8860B',
//            'darkgray'=>'A9A9A9',
//            'darkgreen'=>'006400',
//            'darkgrey'=>'A9A9A9',
//            'darkkhaki'=>'BDB76B',
//            'darkmagenta'=>'8B008B',
//            'darkolivegreen'=>'556B2F',
//            'darkorange'=>'FF8C00',
//            'darkorchid'=>'9932CC',
//            'darkred'=>'8B0000',
//            'darksalmon'=>'E9967A',
//            'darkseagreen'=>'8FBC8F',
//            'darkslateblue'=>'483D8B',
//            'darkslategray'=>'2F4F4F',
//            'darkslategrey'=>'2F4F4F',
//            'darkturquoise'=>'00CED1',
//            'darkviolet'=>'9400D3',
//            'deeppink'=>'FF1493',
//            'deepskyblue'=>'00BFFF',
//            'dimgray'=>'696969',
//            'dimgrey'=>'696969',
//            'dodgerblue'=>'1E90FF',
//            'firebrick'=>'B22222',
//            'floralwhite'=>'FFFAF0',
//            'forestgreen'=>'228B22',
//            'fuchsia'=>'FF00FF',
//            'gainsboro'=>'DCDCDC',
//            'ghostwhite'=>'F8F8FF',
//            'gold'=>'FFD700',
//            'goldenrod'=>'DAA520',
//            'gray'=>'808080',
//            'green'=>'008000',
//            'greenyellow'=>'ADFF2F',
//            'grey'=>'808080',
//            'honeydew'=>'F0FFF0',
//            'hotpink'=>'FF69B4',
//            'indianred'=>'CD5C5C',
//            'indigo'=>'4B0082',
//            'ivory'=>'FFFFF0',
//            'khaki'=>'F0E68C',
//            'lavender'=>'E6E6FA',
//            'lavenderblush'=>'FFF0F5',
//            'lawngreen'=>'7CFC00',
//            'lemonchiffon'=>'FFFACD',
//            'lightblue'=>'ADD8E6',
//            'lightcoral'=>'F08080',
//            'lightcyan'=>'E0FFFF',
//            'lightgoldenrodyellow'=>'FAFAD2',
//            'lightgray'=>'D3D3D3',
//            'lightgreen'=>'90EE90',
//            'lightgrey'=>'D3D3D3',
//            'lightpink'=>'FFB6C1',
//            'lightsalmon'=>'FFA07A',
//            'lightseagreen'=>'20B2AA',
//            'lightskyblue'=>'87CEFA',
//            'lightslategray'=>'778899',
//            'lightslategrey'=>'778899',
//            'lightsteelblue'=>'B0C4DE',
//            'lightyellow'=>'FFFFE0',
//            'lime'=>'00FF00',
//            'limegreen'=>'32CD32',
//            'linen'=>'FAF0E6',
//            'magenta'=>'FF00FF',
//            'maroon'=>'800000',
//            'mediumaquamarine'=>'66CDAA',
//            'mediumblue'=>'0000CD',
//            'mediumorchid'=>'BA55D3',
//            'mediumpurple'=>'9370D0',
//            'mediumseagreen'=>'3CB371',
//            'mediumslateblue'=>'7B68EE',
//            'mediumspringgreen'=>'00FA9A',
//            'mediumturquoise'=>'48D1CC',
//            'mediumvioletred'=>'C71585',
//            'midnightblue'=>'191970',
//            'mintcream'=>'F5FFFA',
//            'mistyrose'=>'FFE4E1',
//            'moccasin'=>'FFE4B5',
//            'navajowhite'=>'FFDEAD',
//            'navy'=>'000080',
//            'oldlace'=>'FDF5E6',
//            'olive'=>'808000',
//            'olivedrab'=>'6B8E23',
//            'orange'=>'FFA500',
//            'orangered'=>'FF4500',
//            'orchid'=>'DA70D6',
//            'palegoldenrod'=>'EEE8AA',
//            'palegreen'=>'98FB98',
//            'paleturquoise'=>'AFEEEE',
//            'palevioletred'=>'DB7093',
//            'papayawhip'=>'FFEFD5',
//            'peachpuff'=>'FFDAB9',
//            'peru'=>'CD853F',
//            'pink'=>'FFC0CB',
//            'plum'=>'DDA0DD',
//            'powderblue'=>'B0E0E6',
//            'purple'=>'800080',
//            'red'=>'FF0000',
//            'rosybrown'=>'BC8F8F',
//            'royalblue'=>'4169E1',
//            'saddlebrown'=>'8B4513',
//            'salmon'=>'FA8072',
//            'sandybrown'=>'F4A460',
//            'seagreen'=>'2E8B57',
//            'seashell'=>'FFF5EE',
//            'sienna'=>'A0522D',
//            'silver'=>'C0C0C0',
//            'skyblue'=>'87CEEB',
//            'slateblue'=>'6A5ACD',
//            'slategray'=>'708090',
//            'slategrey'=>'708090',
//            'snow'=>'FFFAFA',
//            'springgreen'=>'00FF7F',
//            'steelblue'=>'4682B4',
//            'tan'=>'D2B48C',
//            'teal'=>'008080',
//            'thistle'=>'D8BFD8',
//            'tomato'=>'FF6347',
//            'turquoise'=>'40E0D0',
//            'violet'=>'EE82EE',
//            'wheat'=>'F5DEB3',
//            'white'=>'FFFFFF',
//            'whitesmoke'=>'F5F5F5',
//            'yellow'=>'FFFF00',
//            'yellowgreen'=>'9ACD32');
//
//        $color_name = strtolower($color_name);
//        if (isset($colors[$color_name]))
//        {
//            return ('#' . $colors[$color_name]);
//        }
//        else
//        {
//            return ($color_name);
//        }
//    }
}
