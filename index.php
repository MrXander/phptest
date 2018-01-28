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
<script type="text/x-template" id="item-template">
<!--    <span>bbb {{ model.ruleForm2.pass }} bbbb</span>-->
        <el-form :model="model.ruleForm2" status-icon :rules="model.rules2" ref="ruleForm2" v-show="model.addOrderFormVisible"
                 label-width="120px" class="demo-ruleForm">
            <el-form-item label="Password" prop="pass">
                <el-input type="password" v-model="model.ruleForm2.pass" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="Confirm" prop="checkPass">
                <el-input type="password" v-model="model.ruleForm2.checkPass" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="Age" prop="age">
                <el-input v-model.number="model.ruleForm2.age"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm2')">Submit</el-button>
                <el-button @click="resetForm('ruleForm2')">Reset</el-button>
            </el-form-item>
        </el-form>
</script>
<div id="app">
    <item :model="test"></item>

    <el-container style="height: 500px;">
        <el-container>
            <el-header style="text-align: right; font-size: 12px">
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
                            <el-button type="text" size="small" @click="placeOrder(scope.row)"
                                       v-if="loggedAs == loggedAsCustomer">Place order
                            </el-button>
                            <el-button type="text" size="small" @click="takeOrder(scope.row)" v-else>Take order
                            </el-button>
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
    </el-dialog>

</div>


<script>
    const store = new Vuex.Store({
        state: {
            // logInfo: {
            //     loggedAs: 'customer',
            //     loggedAsCustomer: 'customer',
            //     loggedAsContractor: 'contractor'
            // },
            //modalVisible: true,
            addOrderFormVisible: false,
            addOrderData: null
        },
        mutations: {
            // showRoleSelector (state) {
            //     state.modalVisible = true;
            // },
            showAddOrderForm(state) {
                state.addOrderFormVisible = true;
            }
        }
    });

    Vue.component('item', {
        template: '#item-template',
        data: {
            ruleForm2: {
                pass: '',
                checkPass: '',
                age: ''
            },
            rules2: {
                pass: [
                    {validator: this.validatePass, trigger: 'blur'}
                ],
                checkPass: [
                    {validator: this.validatePass2, trigger: 'blur'}
                ],
                age: [
                    {validator: this.checkAge, trigger: 'blur'}
                ]
            }
        },
        props: {
            model: Object
        },
    });

    const addOrderForm = Vue.component('addOrderForm', {
        template: '#item',
        data: {
            ruleForm2: {
                pass: '',
                checkPass: '',
                age: ''
            },
            rules2: {
                pass: [
                    {validator: this.validatePass, trigger: 'blur'}
                ],
                checkPass: [
                    {validator: this.validatePass2, trigger: 'blur'}
                ],
                age: [
                    {validator: this.checkAge, trigger: 'blur'}
                ]
            }
        },
        methods: {
            checkAge(rule, value, callback) {
                if (!value) {
                    return callback(new Error('Please input the age'));
                }
                setTimeout(() => {
                    if (!Number.isInteger(value)) {
                        callback(new Error('Please input digits'));
                    } else {
                        if (value < 18) {
                            callback(new Error('Age must be greater than 18'));
                        } else {
                            callback();
                        }
                    }
                }, 1000);
            },
            validatePass(rule, value, callback) {
                if (value === '') {
                    callback(new Error('Please input the password'));
                } else {
                    if (this.ruleForm2.checkPass !== '') {
                        this.$refs.ruleForm2.validateField('checkPass');
                    }
                    callback();
                }
            },
            validatePass2(rule, value, callback) {
                if (value === '') {
                    callback(new Error('Please input the password again'));
                } else if (value !== this.ruleForm2.pass) {
                    callback(new Error('Two inputs don\'t match!'));
                } else {
                    callback();
                }
            }

        },
        computed: {
            isVisible: function() {
                return this.$store.state.addOrderFormVisible;
            }
        }
    });

    const app = new Vue({
        el: '#app',
        //store,
        //components: {addOrderForm},
        data: {
            orders: null,
            loggedAs: 'customer',
            modalVisible: true,
            addOrderFormVisible: false,
            loggedAsCustomer: 'customer',
            loggedAsContractor: 'contractor',
            test: {
                addOrderFormVisible: false,
                ruleForm2: {
                    pass: '',
                    checkPass: '',
                    age: ''
                },
                rules2: {
                    pass: [
                        {validator: this.validatePass, trigger: 'blur'}
                    ],
                    checkPass: [
                        {validator: this.validatePass2, trigger: 'blur'}
                    ],
                    age: [
                        {validator: this.checkAge, trigger: 'blur'}
                    ]
                }
            },
            ruleForm2: {
                pass: '',
                checkPass: '',
                age: ''
            },
            rules2: {
                pass: [
                    {validator: this.validatePass, trigger: 'blur'}
                ],
                checkPass: [
                    {validator: this.validatePass2, trigger: 'blur'}
                ],
                age: [
                    {validator: this.checkAge, trigger: 'blur'}
                ]
            }
        },
        created: function () {
            this.fetchData();
        },
        methods: {
            fetchData: function () {
                var xhr = new XMLHttpRequest();
                var self = this;
                xhr.open('GET', 'api/orders.php');
                xhr.onload = function () {
                    self.orders = JSON.parse(xhr.responseText);
                    console.log(self.orders);
                };
                xhr.send();
            },
            takeOrder: function (order) {


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
            },
            showAddOrderForm: function () {
                this.$store.commit('showAddOrderForm')
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        alert('submit!');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            checkAge(rule, value, callback) {
                if (!value) {
                    return callback(new Error('Please input the age'));
                }
                setTimeout(() => {
                    if (!Number.isInteger(value)) {
                        callback(new Error('Please input digits'));
                    } else {
                        if (value < 18) {
                            callback(new Error('Age must be greater than 18'));
                        } else {
                            callback();
                        }
                    }
                }, 1000);
            },
            validatePass(rule, value, callback) {
                if (value === '') {
                    callback(new Error('Please input the password'));
                } else {
                    if (this.ruleForm2.checkPass !== '') {
                        this.$refs.ruleForm2.validateField('checkPass');
                    }
                    callback();
                }
            },
            validatePass2(rule, value, callback) {
                if (value === '') {
                    callback(new Error('Please input the password again'));
                } else if (value !== this.ruleForm2.pass) {
                    callback(new Error('Two inputs don\'t match!'));
                } else {
                    callback();
                }
            }

        }
    });
</script>
</body>
</html>