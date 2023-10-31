CKEDITOR.on('instanceReady', function(ev) {
  // Sets indentation of source code
  ev.editor.dataProcessor.writer.setRules( 'div', {
              indent: true,
              breakBeforeOpen: true,
              breakAfterOpen: true,
              breakBeforeClose: true,
              breakAfterClose: true
          });
});
// allow i tags to be empty
CKEDITOR.dtd.$removeEmpty['i'] = false;