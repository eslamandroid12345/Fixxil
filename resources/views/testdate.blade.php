{{-- <!DOCTYPE html><html lang="en">
    <head>
        <title>Essential JS 2 Calendar control</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Typescript UI Controls">
        <meta name="author" content="Syncfusion">
        <!--style reference from the Calendar component-->
        <link href="https://cdn.syncfusion.com/ej2/25.2.3/ej2-base/styles/material.css" rel="stylesheet">
        <link href="https://cdn.syncfusion.com/ej2/25.2.3/ej2-buttons/styles/material.css" rel="stylesheet">
        <link href="https://cdn.syncfusion.com/ej2/25.2.3/ej2-calendars/styles/material.css" rel="stylesheet">
        <!--style reference from app-->
        <link href="styles.css" rel="stylesheet">

        <script src="https://cdn.syncfusion.com/ej2/25.2.3/dist/ej2.min.js" type="text/javascript"></script>
        <script src="https://cdn.syncfusion.com/ej2/syncfusion-helper.js" type ="text/javascript"></script>
    </head>

    <body>
        <div id="container">
            <!--element which is going to render the Calendar-->
            <input type="date" name="dd" />
            <div id="element"></div>
        </div>

        <script>
            var ele = document.getElementById('container');
            if(ele)
            {
                ele.style.visibility = "visible";
            }
        </script>
        <script >
            ej.base.enableRipple(true);
            var span;
            var addClass = ej.base.addClass;
            var calendar = new ej.calendars.Calendar({
                calendarMode: 'Islamic',
                renderDayCell: disableDate
            });
            calendar.appendTo('#element');

            function disableDate(args)
            {
                /*Date need to be disabled*/
                if (args.date.getDate() === 2 || args.date.getDate() === 10 || args.date.getDate() === 28)
                {
                    args.isDisabled = true;
                }
                if (args.date.getDate() === 13)
                {
                    span = document.createElement('span');
                    args.element.children[0].className += 'e-day sf-icon-cup highlight';
                    addClass([args.element], ['special', 'e-day', 'dinner']);
                    args.element.setAttribute('data-val', ' Dinner !');
                    args.element.appendChild(span);
                }
                if (args.date.getDate() === 23)
                {
                    args.element.children[0].className += 'e-day sf-icon-start highlight';
                    span = document.createElement('span');
                    span.setAttribute('class', 'sf-icons-star highlight');
                    //use the imported method to add the multiple classes to the given element
                    addClass([args.element], ['special', 'e-day', 'holiday']);
                    args.element.setAttribute('data-val', ' Holiday !');
                    args.element.appendChild(span);
                }
            }
        </script>
    </body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Essential JS 2 Calendar control</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Typescript UI Controls">
    <meta name="author" content="Syncfusion">
    <!--style reference from the Calendar component-->
    <link href="https://cdn.syncfusion.com/ej2/25.2.3/ej2-base/styles/material.css" rel="stylesheet">
    <link href="https://cdn.syncfusion.com/ej2/25.2.3/ej2-buttons/styles/material.css" rel="stylesheet">
    <link href="https://cdn.syncfusion.com/ej2/25.2.3/ej2-calendars/styles/material.css" rel="stylesheet">
    <!--style reference from app-->
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.syncfusion.com/ej2/25.2.3/dist/ej2.min.js" type="text/javascript"></script>
    <script src="https://cdn.syncfusion.com/ej2/syncfusion-helper.js" type ="text/javascript"></script>
</head>

<body>
    <div id="container">
        <!--element which is going to render the Calendar-->
        <div id="element"></div>
    </div>

    <script>
        var ele = document.getElementById('container');
        if(ele) {
            ele.style.visibility = "visible";
        }

        ej.base.enableRipple(true);

        var span;
        var addClass = ej.base.addClass;

        var calendar = new ej.calendars.Calendar({
            calendarMode: 'Islamic',
            renderDayCell: disableDate
        });
        calendar.appendTo('#element');

        function disableDate(args) {
            /* Date need to be disabled */
            if (args.date.getDate() === 2 || args.date.getDate() === 10 || args.date.getDate() === 28) {
                args.isDisabled = true;
                // Store in localStorage
                localStorage.setItem('disabledDate-' + args.date.toDateString(), 'true');
            }
            if (args.date.getDate() === 13) {
                span = document.createElement('span');
                args.element.children[0].className += 'e-day sf-icon-cup highlight';
                addClass([args.element], ['special', 'e-day', 'dinner']);
                args.element.setAttribute('data-val', 'Dinner!');
                args.element.appendChild(span);
                // Store in localStorage
                localStorage.setItem('specialDate-' + args.date.toDateString(), 'Dinner!');
            }
            if (args.date.getDate() === 23) {
                args.element.children[0].className += 'e-day sf-icon-start highlight';
                span = document.createElement('span');
                span.setAttribute('class', 'sf-icons-star highlight');
                // Use the imported method to add multiple classes to the given element
                addClass([args.element], ['special', 'e-day', 'holiday']);
                args.element.setAttribute('data-val', 'Holiday!');
                args.element.appendChild(span);
                // Store in localStorage
                localStorage.setItem('specialDate-' + args.date.toDateString(), 'Holiday!');
            }
        }
    </script>
</body>
</html>
