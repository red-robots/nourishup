(function() {
  tinymce.PluginManager.add( 'checklistbutton', function( editor, url ) {
      //console.log(url);
      var parts = url.split('assets');
      var themeURL = parts[0];
      
      // Add Button to Visual Editor Toolbar
      editor.addButton('custom_class', {
          title: 'Checklist',
          cmd: 'custom_class',
          image: themeURL + 'assets/img/checklist.png',
      });

      // Add Command when Button Clicked
      editor.addCommand('custom_class', function() {
          //alert('Button clicked!');
          // var selected_text = editor.selection.getContent({
          //   'format': 'html'
          // });

          var selected_text = editor.selection.getContent();
          if ( selected_text.length === 0 ) {
              alert( 'Please select some text.' );
              return;
          }
          var open_column = '<div class="ChecklistWrap">';
          var close_column = '</div>';
          var return_text = '';
          return_text = open_column + selected_text + close_column;
          editor.execCommand('mceReplaceContent', false, return_text);
          return;

          //var selected_text = editor.selection.getContent();
          // var selected_text = editor.selection.getContent({
          //   'format': 'html'
          // });
          
          // var return_text = '';
          // return_text = '<span class="dropcap">' + selected_text + '</span>';
          // editor.execCommand('mceInsertContent', 0, return_text);
      });

  });

  tinymce.PluginManager.add( 'ctabutton', function( editor, url ) {
      //console.log(url);
      var parts = url.split('assets');
      var themeURL = parts[0];
      
      // Add Button to Visual Editor Toolbar
      editor.addButton('edbutton1', {
          title: 'Button Dark Orange',
          cmd: 'edbutton1',
          image: themeURL + 'assets/img/button-orange.png',
      });

      // Add Command when Button Clicked
      editor.addCommand('edbutton1', function() {
        var selected_text = editor.selection.getContent();
        if ( selected_text.length === 0 ) {
            alert( 'Please select some text.' );
            return;
        }
        var open_column = '<span class="custom-button-element white"><a data-mce-href="#" href="#"  data-mce-selected="inline-boundary" class="button-element button">';
        var close_column = '</a></span>';
        var return_text = '';
        return_text = open_column + selected_text + close_column;
        editor.execCommand('mceReplaceContent', false, return_text);
        return;
      });
  });

})();