<?php

$png = '../img/1.png';
$jpg = '../img/2.jpg';

var_dump(exif_imagetype($png)); // int(3)
echo exif_imagetype($png) == IMAGETYPE_PNG ? $png . '是 PNG 图片' : $png . '不是 PNG 图片', PHP_EOL;
// ../img/1.png是 PNG 图片

var_dump(exif_imagetype($jpg)); // int(2)
echo exif_imagetype($jpg) == IMAGETYPE_JPEG ? $jpg . '是 jpg 图片' : $jpg . '不是 JPG 图片', PHP_EOL;
// ../img/2.jpg是 jpg 图片

var_dump(getimagesize($jpg));
// array(7) {
//     [0]=>
//     int(300)
//     [1]=>
//     int(244)
//     [2]=>
//     int(2)
//     [3]=>
//     string(24) "width="300" height="244""
//     ["bits"]=>
//     int(8)
//     ["channels"]=>
//     int(3)
//     ["mime"]=>
//     string(10) "image/jpeg"
//   }

var_dump(exif_read_data($png));
// PHP Warning:  exif_read_data(1.png): File not supported in /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202011/source/11.使用PHP获取图像文件的EXIF信息.php on line 14

// Warning: exif_read_data(1.png): File not supported in /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202011/source/11.使用PHP获取图像文件的EXIF信息.php on line 14

// bool(false)

var_dump(exif_read_data($jpg));
// array(8) {
//     ["FileName"]=>
//     string(5) "2.jpg"
//     ["FileDateTime"]=>
//     int(1605061174)
//     ["FileSize"]=>
//     int(19075)
//     ["FileType"]=>
//     int(2)
// ……
// ……

var_dump(read_exif_data($jpg));
// PHP Deprecated:  Function read_exif_data() is deprecated in /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202011/source/11.使用PHP获取图像文件的EXIF信息.php on line 17

// Deprecated: Function read_exif_data() is deprecated in /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202011/source/11.使用PHP获取图像文件的EXIF信息.php on line 17
// array(8) {
//   ["FileName"]=>
//   string(5) "2.jpg"
//   ["FileDateTime"]=>
//   int(1605061174)
//   ["FileSize"]=>
// ……
// ……

echo "256: " . exif_tagname(256) . PHP_EOL;
// 256: ImageWidth
for ($id = 1; $id <= 65535; $id++) {
    if (exif_tagname($id) != "") {
        echo $id . ' ( ' . exif_tagname($id) . ' )', PHP_EOL;
    }
}
// 11 ( ACDComment )
// 254 ( NewSubFile )
// 255 ( SubFile )
// 256 ( ImageWidth )
// 257 ( ImageLength )
// 258 ( BitsPerSample )
// 259 ( Compression )
// ……
// ……
// ……

var_dump(exif_thumbnail('../img/3.jpeg'));
// string(14369) "�����

//                         !"$��@"���

// }!1AQa"q2��#B��R��$3br�
// %&'()*456789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz�������������������������������������������������������������������������

// w!1AQaq"2B����  #3R�br�
// $4�%�&'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz��������������������������������������������������������������������������
//                                                                                                                           ?�b�������������?J�l�2

file_put_contents('../img/3-thumbnail.jpeg', exif_thumbnail('../img/3.jpeg'));

var_dump(exif_read_data('../img/3.jpeg'));
// array(56) {
//     ["FileName"]=>
//     string(6) "3.jpeg"
//     ["FileDateTime"]=>
//     int(1606698637)
//     ["FileSize"]=>
//     int(8772487)
//     ["FileType"]=>
//     int(2)
//     ["MimeType"]=>
//     string(10) "image/jpeg"
//     ["SectionsFound"]=>
//     string(44) "ANY_TAG, IFD0, THUMBNAIL, EXIF, GPS, INTEROP"
//     ["COMPUTED"]=>
//     array(10) {
//       ["html"]=>
//       string(26) "width="5792" height="4344""
//       ["Height"]=>
//       int(4344)
//       ["Width"]=>
//       int(5792)
//       ["IsColor"]=>
//       int(1)
//       ["ByteOrderMotorola"]=>
//       int(1)
//       ["ApertureFNumber"]=>
//       string(5) "f/1.7"
//       ["Thumbnail.FileType"]=>
//       int(2)
//       ["Thumbnail.MimeType"]=>
//       string(10) "image/jpeg"
//       ["Thumbnail.Height"]=>
//       int(240)
//       ["Thumbnail.Width"]=>
//       int(320)
//     }
//     ["ImageWidth"]=>
//     int(5792)
//     ["Model"]=>
//     string(5) "Mi 10"
//     ["ImageLength"]=>
//     int(4344)
//     ["Orientation"]=>
//     int(6)
//     ["DateTime"]=>
//     string(19) "2020:11:30 09:10:17"
//     ["YCbCrPositioning"]=>
//     int(1)
//     ["Exif_IFD_Pointer"]=>
//     int(207)
//     ["ResolutionUnit"]=>
//     int(2)
//     ["GPS_IFD_Pointer"]=>
//     int(5368)
//     ["XResolution"]=>
//     string(4) "72/1"
//     ["YResolution"]=>
//     string(4) "72/1"
//     ["Make"]=>
//     string(6) "Xiaomi"
//     ["THUMBNAIL"]=>
//     array(9) {
//       ["JPEGInterchangeFormat"]=>
//       int(5504)
//       ["Orientation"]=>
//       int(6)
//       ["JPEGInterchangeFormatLength"]=>
//       int(14369)
//       ["Compression"]=>
//       int(6)
//       ["ResolutionUnit"]=>
//       int(2)
//       ["XResolution"]=>
//       string(4) "72/1"
//       ["YResolution"]=>
//       string(4) "72/1"
//       ["ExifImageLength"]=>
//       int(240)
//       ["ExifImageWidth"]=>
//       int(320)
//     }
//     ["UndefinedTag:0x9AAA"]=>
//     string(4480) "1y�L�=w%�s_�&��v��oJ��$Gdz|d�9n�
//   �������~��+9����2V:+�о�Qn]�۲͐� ��U��nwF��w;f�h�k���i*w�bd+�D0�=\o��y����x\�,��BS��#/d�9���˓
//                                                                                             ,%C�3���eIZ~��������oLܰܡ~�}#�y:4Ӥ}�    ��dȻGI*Y��
//                                                                                                                                             ��m�)��x#a�6J<���2�z�B3���2�Ol*8
//           w       W�"E�c���OV�l9����                                                                                                                                        p�f�����KAFUg���<I���ʯ9E�S�
//   ����U�ޘ�CO�>ʈ7��ݪG�T&,� Ie�%�
  
//   ?��S���§�9��6s��8LT&o
//   Vn�Џ�R��c6��Ϝ p�G�f#��/�o����_�@�$�%#
//                                        � �Ҡ��5v��~����Ȣ)�ڽa�i�:���\�}��3xKM�CIe�����5&�/��䇃�隙R�+��He��}���b�Ґ�?��aaJ1�D�9�˘�r�i�����g�u_Q^�
//   FQ�Y�9"��S箠�;�|�J�+eR٨~��ّ�ý��7�C#G"����
//   "��x�B*US9a�0�k��ˀ,���F�T(����6�y
//   �5���R�Y��?�@X�A�7\��V9��@�      �i;���Ͼ�Է�V,��d�A���g���ۺ�5��"��ٺbt��FҞ�`Փ!�zQR��V���Xbf���k��G���e�o
//                              �lк\�p�J'�;�4.�>��U 3�.<|\a���
//   �[5_2T]���mk�g6*�߷��=2�琯��Ԝ��l~�a�y%"�B�3����(��ܛ�̔ڀ,�ق⛘Wy�\B��J�Mg{�Ӗ�d���I!>?b���:�2
//                                                                                         �h���?a��e/�AH#��фNjK�9�~)�ʮX�>�����?J%�Yw/_�<T
//                                                                                                                                        ��60
//                                                                                                                                            gU��Q���c�1�7�z��ג�"V`�_:��ԂB�mP���X�p$ʭ�v?�[��ʻ�!������^���zq��t�V�ߤ!32��K����_��
//                                                                                                                                                                                                                              �=v&��
//   �r�.�
//   �Ex�,dL�6Ef\��B4��"��z/����7dⴍĢܡ(�a�kh��;��A`pQl�MH�] W��������9#�Z*$�ePP�5����-p��Ѝ6������ǽ�[:�Y����*B�%       �lx �wt����Ծ;:|YL͌��9�6/)����{gD
//                                                                                                                                                  ]_p)5��`�R���o~�g�����
//   �m�}�2��
//   V2��R���E����rDو�WF�����MB���ʋwy��4�q�(�"�蹉�Ɠ"�j�$��螭��+"�U��`P �Z����{       �J^>�*+Ə@}�D�ō�c��
//                        P�q�)�pG���)�h!E���K���+JQr��Qd    ���O]�l�y5��B���z�X���Ҵ�OAˣ0��Xo�]"4L�,�������U���%�}9عT�MӼ4m�Ӳɮ��l}���Pn��J�*U��,���7wVQ{�p�\���
//                                                                                                                                                            ��M:��6��
//   Լ�*:� /�� M�H��~H�3�"��R��C�x�}ǉZ���uv����y��%Gf�i��ɤ�0��vZ"��7/[mdфx������oM@��w�t���^uM�R�w_�aD���P$T�c�Xg-v�6욢�>k��$Y                                         @j�֠�wƂĭ�
//   U���(A�'��]V2�!7�_�i    �����o0;�Z��*�^�&ӿ3�CY*��B֯/1��#�ؖ'u:���j�                                                         eAV(71�W��eaa&��R���m
//                                                                   �$
//                                                                     ����}s�6���CkL�,>���9�K��W
//   ��O�.���3x�˽�tk�n�Nq �>/L��[���ê�����A������Ŀ����D��L?���Κ�^�9HY�:@�r�f`�       h���4�Tr���<�+0��B޴ބ��ي`���i�Ȑ�G�@߹�Vj�-�L�     �
//                                                                                                                                    ��#"�_Ş��������K1�B��  �6��>P  rQA�Ʃz��k];�Q(CN�\�A
//   �_�v�9��X_���b>
//                 0<�ΡB�H�j6��%����*[.�*j�*D:����j�a������/5�����8�����'v$W$`A3aH�� ���Z��ò�p�F�����C���N[��J�h{�E4��#틼4R����!�!w�����"j�<0*��,k�xi��֚      �cˡ�E^J�1l`O��hD��s�{1��C�_>�B*E]ɕh��`���c�c@pF�b( �!+�]�$��޷ad�G�r#�8���0}��%��v��J���{5+HeNР|!E$��3������~vWC0q��ij��N]��ۋ��V�]�v���!~5�%}��V����Q�5=��(M������Y4�&�FƔ����l�Je�&�w��
//   [�flTh�'?F���� Z1��������47�¦ɤ��zF���K.��                    f-:�.sy�p��/\���
//                                            ]���;=�C^���Qj��@�b��w�̲        ��M�wk����c]rSJ�[v�X��T��a�
//   �S�sU5�@��'�9���vW�,�-�y3xuIE��=
//   �       �*��R�+�GWc�n7+4� �!�-�Bz�(��ؠ�D��FUBE���Ֆ�#�*j���ⲋ?� �ɖ"`���?
//                                                                         �տ�TߐeO�]3s3+e��[�L$L�uXx�ĵ�Y��%Y
//   ��E��`{�MH헛�iIbt�y����:����5�I��8                                                                     �N�����9$��ܽ>Ms<I�H\2d�x���2����e�ՎLW�$q�J���:V�ؠX��I��!P|��*�    �����,� nň�k�v�N�
//   ��1t�+h��{��s*3�tN����i�[O僚��Py�ǡZĸ�V�)����偭`Ո��Q�E���"���+���{       ��G��$XF�w[�3�/��!�(    ���<&V2n��}z8�j^�o�J��3�{�<����YSN%A�6�F����_B�P{Ɨ6}~Ru{�WN`��Y�
//   t
//    ��e5$�}"�d�8\�4�<:
//   �?��0�&59i�2�K6�K�jB�<�.�m��8������s��S�-��:c�^��]M�nj%�L�"u[����5��mH�L�R"��Z0���|�@(�}��8��{�ɶPOSF@�mA�@      ���1�$�f�8��I��1�j��E   �%wx�٦����[��^�j��gG�~���s�;1�ˣ--*A�x��mN��i6��_��fS�ۈr=�S�B͐2zV3�X����W���}�q
//   m���M�{C�ٸ4�Y4hDP7�O�\O7�n�hK����&����  m]~:�k�lEܸe�[�[�\~ղ����?�Y,�(�������+�9�NE�Lo���E�1���^�+�1>�x-HxV�JW�Λ�D���f�U@�s�lq�`$3�N0k��`.1�]��`�"�
//                                                                                                                                                    #C�h�n�^��K���Y�7�u
//                                                                                                                                                                       �_g�����x�f%����*h�ܤ��J����k_ M#6�5gg��\S�郝O��S_�u$�}тi�(k/t6���ֺ��Kt80�"�`]����o�����n��b\�}Ľ_�T�r՝]i���W�E��r]�,�qä]����z��
//                                    ��D�>u��TLQ��:��H5��\n��2\���7�nW=8��}��������pۇ]ȟk�~�2p��m�A��ӡ$����ߵ:�ͤ��Y��س:�R`2�댠�͍���*V��%K0v
//                                                                                                                                      �q5I��pP�L�,d��R=��
//   �x���{o�#��Ve]���,'wF~�����bN��E]j�jXVͼq���+�R.�A��⸄��SN|u_L�M�3e"                                                                                    :%/[��UߖdĔ>:l:��M�����]# K�W�!���ڼJ?�xy��תBۇg�`!@�
//     ["ISOSpeedRatings"]=>
//     int(135)
//     ["ExposureProgram"]=>
//     int(2)
//     ["FNumber"]=>
//     string(7) "169/100"
//     ["ExposureTime"]=>
//     string(5) "1/100"
//     ["UndefinedTag:0x9999"]=>
//     string(111) "{"mirror":false,"?sensor_type":"rear","Hdr":"off","OpMode":36866,"AIScene":0,"FilterId":66048,"ZoomMultiple":1}"
//     ["SensingMethod"]=>
//     int(1)
//     ["UndefinedTag:0x8895"]=>
//     int(0)
//     ["SubSecTimeDigitized"]=>
//     string(6) "999503"
//     ["SubSecTimeOriginal"]=>
//     string(6) "999503"
//     ["SubSecTime"]=>
//     string(6) "999503"
//     ["FocalLength"]=>
//     string(9) "6720/1000"
//     ["Flash"]=>
//     int(16)
//     ["LightSource"]=>
//     int(21)
//     ["MeteringMode"]=>
//     int(2)
//     ["SceneCaptureType"]=>
//     int(0)
//     ["InteroperabilityOffset"]=>
//     int(5338)
//     ["FocalLengthIn35mmFilm"]=>
//     int(24)
//     ["MaxApertureValue"]=>
//     string(7) "151/100"
//     ["DateTimeDigitized"]=>
//     string(19) "2020:11:30 09:10:17"
//     ["ExposureBiasValue"]=>
//     string(3) "0/6"
//     ["ExifImageLength"]=>
//     int(4344)
//     ["WhiteBalance"]=>
//     int(0)
//     ["DateTimeOriginal"]=>
//     string(19) "2020:11:30 09:10:17"
//     ["BrightnessValue"]=>
//     string(7) "284/100"
//     ["ExifImageWidth"]=>
//     int(5792)
//     ["ExposureMode"]=>
//     int(0)
//     ["ApertureValue"]=>
//     string(7) "151/100"
//     ["ComponentsConfiguration"]=>
//     string(4) ""
//     ["ColorSpace"]=>
//     int(1)
//     ["SceneType"]=>
//     string(1) ""
//     ["ShutterSpeedValue"]=>
//     string(9) "6643/1000"
//     ["ExifVersion"]=>
//     string(4) "0220"
//     ["FlashPixVersion"]=>
//     string(4) "0100"
//     ["InterOperabilityIndex"]=>
//     string(3) "R98"
//     ["InterOperabilityVersion"]=>
//     string(4) "0100"
//   }