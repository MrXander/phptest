<html>
<head>
    <title>Vk test</title>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

</head>
<body>
<div id="app">
    <ul>
        <template v-for="order in orders">
            <li>{{order.id}} {{order.title}} {{order.customer}}</li>
        </template>
    </ul>
</div>
<ul>
</ul>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            orders: null
        },
        created: function () {
            this.fetchData();
        },
        methods: {
            fetchData: function () {
                var xhr = new XMLHttpRequest();
                var self = this;
                xhr.open('GET', '/vktest/orders.php');
                xhr.onload = function () {
                    self.orders = JSON.parse(xhr.responseText);
                    console.log(self.orders);
                }
                xhr.send();
            }
        }
    })
</script>
</body>
</html>