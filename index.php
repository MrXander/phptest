<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">

    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>

    <title>Vk test</title>
</head>
<body>
<div id="app" class="container">
    <el-container style="height: 500px;">
        <el-container>
            <el-header style="text-align: right; font-size: 12px">
<!--                <el-dropdown>-->
<!--                    -->
<!--                    <el-dropdown-menu slot="dropdown">-->
<!--                        <el-dropdown-item>Change role</el-dropdown-item>-->
<!--                    </el-dropdown-menu>-->
<!--                </el-dropdown>-->
                <span>Logged as: {{ loggedAs }}</span>
                <el-button type="default" icon="el-icon-setting" size="mini" @click="showModal"></el-button>

            </el-header>

            <el-main>
                <el-table :data="orders">
                    <el-table-column prop="id" label="#" width="30">
                    </el-table-column>
                    <el-table-column prop="title" label="Order title" width="120">
                    </el-table-column>
                    <el-table-column prop="customer" label="Customer" width="140">
                    </el-table-column>
                    <el-table-column label="Action" width="100">
                        <template slot-scope="scope">
                            <el-button type="text" size="small" v-if="loggedAs == loggedAsCustomer">Take order
                            </el-button>
                            <el-button type="text" size="small" v-else>Place order</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-main>
        </el-container>
    </el-container>

    <!-- template for the modal component -->
    <el-dialog title="Choose your destiny" :visible.sync="modalVisible" width="30%" :before-close="handleClose">
        <span>I want to login as:</span>
        <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="logAsCustomer">Customer</el-button>
    <el-button type="primary" @click="logAsContractor">Contractor</el-button>
  </span>
    </el-dialog>

</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            orders: null,
            loggedAs: 'customer',
            modalVisible: true,
            loggedAsCustomer: 'customer',
            loggedAsContractor: 'contractor'

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
                };
                xhr.send();
            },
            takeOrder: function () {

            },
            placeOrder: function () {

            },
            logAsCustomer: function () {
                this.loggedAs = this.loggedAsCustomer;
                this.handleClose();
            },
            logAsContractor: function () {
                this.loggedAs = this.loggedAsContractor;
                this.handleClose();
            },
            handleClose: function (done) {
                this.modalVisible = false;
                this.$message('Logged as: ' + this.loggedAs);
                if (done)
                    done();
            },
            showModal: function () {
                this.modalVisible = true;
            }
    
        }
    })
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>