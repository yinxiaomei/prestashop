tinyMCE.init({
    theme : "advanced",
    mode : "textareas",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",    
    theme_advanced_buttons1 : "mybutton",
    setup : function(ed) {
        // Add a custom button
        ed.addButton('mybutton', {
            title : 'My button',
            image : 'img/example.gif',
            onclick : function() {
                // Add you own code to execute something on click
                ed.focus();
                ed.selection.setContent('Hello world!');
                
            }
        });
    }
        
});

