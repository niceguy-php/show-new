/**
 * Created by qiumeilin on 2015/4/14.
 */
(function(){
    $ = jQuery;
    $(document).ready(function(){
        alert(1);
        $('#qrcode_image').qrcode({
            "render": "div",
            "width": 100,
            "height": 100,
            "color": "#3a3",
            "text": "http://goolya.com/uploads/work_images/14290222974244.jpg"
        });
    });
})();
