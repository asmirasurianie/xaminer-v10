// JavaScript Document

        function openPopup(URL) {

                var window_width=980;
                var window_height=700;
                var from_top=20;
                var from_left=20;
                var has_toolbar='no';
                var has_location='no';
                var has_directories='no';
                var has_status='no';
                var has_menubar='no';
                var has_scrollbars='yes';
                var is_resizeable='no';

var attributes = 'width='+window_width+',height='+window_height+',top='+from_top+',screenY='+from_top+',left='+from_left+',screenX='+from_left+',toolbar='+has_toolbar+',location='+has_location+',directories='+has_directories+',status='+has_status+',menubar='+has_menubar+',scrollbars='+has_scrollbars+',resizeable='+is_resizeable;

                window.open(URL,'',attributes);
        }
