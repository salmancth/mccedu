// Theme color settings
var eliteadminURL = window.location.protocol + '//' + window.location.host + '/sites/all/themes/eliteadmin/';
jQuery(document).ready(function($){
  $("*[theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('theme');
        store('theme', currentStyle);
        $('#theme').attr({href: eliteadminURL + 'css/colors/'+currentStyle+'.css'})
    });

    var currentTheme = get('theme');
    if(currentTheme)
    {
      $('#theme').attr({href: eliteadminURL + 'css/colors/'+currentTheme+'.css'});
    }
    // color selector
    $('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      });

});

 function get(name) {
    
  }

jQuery(document).ready(function($){
    $("*[theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('theme');
        store('theme', currentStyle);
        $('#theme').attr({href: eliteadminURL + 'css/colors/'+currentStyle+'.css'})
    });

    var currentTheme = get('theme');
    if(currentTheme)
    {
      $('#theme').attr({href: eliteadminURL + 'css/colors/'+currentTheme+'.css'});
    }
    // color selector
jQuery('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      });
});

function store(name, val) {
    if (typeof (Storage) !== "undefined") {
      localStorage.setItem(name, val);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
}