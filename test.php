<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">


    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/vuex"></script>
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="./js/mutation-types.js"></script>

    <title>Vk test</title>
</head>
<body>
<!-- item template -->
<script type="text/x-template" id="item-template">
    <li>
        aaaaaaaaaaaaaaaaa

    </li>
</script>

<p>(You can double click on an item to turn it into a folder.)</p>

<!-- the demo root element -->
<ul id="demo">
    <item>
    </item>
</ul>


<script>
    // demo data
    var data = {
        name: 'My Tree',
        children: [
            { name: 'hello' },
            { name: 'wat' },
            {
                name: 'child folder',
                children: [
                    {
                        name: 'child folder',
                        children: [
                            { name: 'hello' },
                            { name: 'wat' }
                        ]
                    },
                    { name: 'hello' },
                    { name: 'wat' },
                    {
                        name: 'child folder',
                        children: [
                            { name: 'hello' },
                            { name: 'wat' }
                        ]
                    }
                ]
            }
        ]
    };

    // define the item component
    Vue.component('item', {
        template: '#item-template',
        data: {}
    });

    // boot up the demo
    var demo = new Vue({
        el: '#demo',
        data: {
            treeData: data
        }
    })

</script>
</body>
</html>