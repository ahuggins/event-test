$(function () {
    $('.datepicker').datetimepicker();
    $('.summernote').summernote({
          toolbar: [
            //[groupname, [button list]]
            ['format', ['style']],
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['picture', 'link', 'video', 'hr']],
            ['misc', ['fullscreen', 'codeview', 'undo', 'redo']],

          ],
          height: 300
        });
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });
    var elem = $("#chars");
    $("#description").limiter(140, elem);

     $(".event-type").chosen({
         single_backstroke_delete: false,
     });
});
