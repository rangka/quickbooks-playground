<?php 
include('include.php');
?>
<html>
    <head>
        <title>Quickbooks Example</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.9.0/vue-resource.min.js" type="text/javascript"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://js.appcenter.intuit.com/Content/IA/intuit.ipp.anywhere-1.3.3.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>

        <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <style>
            body, html {height: 100%;font-family: 'Slabo 27px', sans-serif;font-size: 18px;}
            #main-content {padding: 70px 20px 20px 235px;}
            #top-navbar {margin-left: 215px;background: #98B580;border-bottom-width: 0;}
            #top-navbar a {color: #FFF;}
            #sidebar {position: fixed; top:0; left: 0; width: 215px; background: #222d32;height: 100%;overflow: auto;}
            #sidebar .navbar-brand {font-size: 22px;color:#FFF;border-bottom: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 10px;display: block;width:95%;margin: auto;float: none;text-align: center;}
            #sidebar ul li {}
            #sidebar ul li a {padding: 5px 15px;display: block;color: #FFF;}
            #sidebar ul li.active {background: #8DA877;}
            #sidebar ul li a:hover {background: rgba(255, 255, 255, 0.1);text-decoration: none;}
            #sidebar ul li a:focus {text-decoration: none;}
            .tab-content {padding: 10px;}
            .form-control {font-size: 18px;}
            .result-panel {background: #333;color:#DDD;}
            .result-panel .panel-heading {border-color: #444; background-color: #8DA877;}
            .result-panel .panel-body .response {font-family: monospace;font-size: 14px;white-space: pre;overflow: auto;}
            .result-panel .panel-body b {color: #5bc0de;}
            .result-panel .panel-title a {color: #fff;}
            h3.title {border-bottom: 1px solid rgba(0, 0, 0, 0.1);padding-bottom: 5px;}
        </style>
    </head>

    <body>
        <div>
            <div id="sidebar">
                <a href="#" class="navbar-brand">Rangka/Quickbooks</a>
                <ul class="list-unstyled">
                    <li><a href="index.php">Connect</a></li>
                    <li v-for="(type, item) in entities" :class="getMenuClass(type)"><a href="javascript:void(0);" @click="openEntity(type)">{{ type }}</a></li>
                </ul>
            </div>
            <div id="main-content">
                <div v-if="session.oauth_token" class="navbar navbar-inverse navbar-fixed-top" id="top-navbar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="#">Connected to Company #{{ session.company_id }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <a href="javascript:void(0);" onclick="intuit.ipp.anywhere.controller.onConnectToIntuitClicked();" style="background: #2C9F1C;" class="btn btn-success">
                        Connect to QuickBooks
                    </a>
                </div>

                <div v-if="entity">
                    <h3 class="title">{{ entity }}</h3>
                    <ul class="nav-tabs nav">
                        <li v-for="(actionType, action) in getEntityActions()" :class="getTabClass(actionType)" @click="openTab(actionType)">
                            <a href="javascript:void(0);">{{ actionType }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div v-if="activeTab == 'create'">
                            <div v-if="!getEntityAction()">
                                This action has not been implemented yet.
                            </div>
                            <div v-else>
                                
                            </div>
                        </div>
                        <div v-if="activeTab == 'read'">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="">
                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" class="form-control" v-model="data.id">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info" @click="read()">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel result-panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Response <span class="pull-right"><a href="javascript:void(0);">API Docs</a> | <a href="javascript:void(0);">QB Docs</a></span></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div v-if="loading">
                                                Fetching data, please wait..
                                            </div>
                                            <div v-else>
                                                <div v-if="response" class="response">{{ response }}</div>
                                                <div v-else>
                                                    Enter an ID and press <b>Submit</b>.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="activeTab == 'update'">
                            <div v-if="!getEntityAction()">
                                This action has not been implemented yet.
                            </div>
                            <div v-else>
                                
                            </div>
                        </div>
                        <div v-if="activeTab == 'delete'">
                            <div v-if="!getEntityAction()">
                                This action has not been implemented yet.
                            </div>
                            <div v-else>
                                
                            </div>
                        </div>
                        <div v-if="activeTab == 'query'">
                            <div v-if="!getEntityAction()">
                                This action has not been implemented yet.
                            </div>
                            <div v-else>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="">
                                            <div class="form-group">
                                                <label for="id">Max Results</label>
                                                <input type="text" class="form-control" v-model="data.max_results">
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-info" @click="query()">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel result-panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Response <span class="pull-right"><a href="javascript:void(0);">API Docs</a> | <a href="javascript:void(0);">QB Docs</a></span></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div v-if="loading">
                                                    Fetching data, please wait..
                                                </div>
                                                <div v-else>
                                                    <div v-if="response" class="response">{{ response }}</div>
                                                    <div v-else>
                                                        Enter an ID and press <b>Submit</b>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="activeTab == 'batchRequest'">
                            This action has not been implemented yet.
                        </div>
                        <div v-if="activeTab == 'changeDataCapture'">
                            This action has not been implemented yet.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">
            intuit.ipp.anywhere.setup({
                grantUrl: '<?php echo REDIRECT_URL; ?>',
                datasources: {
                     quickbooks : true
               }
            });

            Vue.config.debug = true
            var vm = new Vue({
                el: "body",
                data: {
                    session: <?php echo json_encode($_SESSION); ?>,
                    loading: false,
                    activeTab: null,
                    entity: null,
                    data: {
                        id: null,
                        max_results: 10
                    },
                    response: null,
                    entities: {
                        Account: {
                            actions: {
                                create: true, 
                                read  : false, 
                                update: false, 
                                query : true
                            }
                        },
                        Attachable: {
                            actions: {
                                create: true,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Batch: {
                            actions: {
                                batchRequest: false
                            }
                        },
                        Bill: {
                            actions: {
                                create: true,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        BillPayment: {
                            actions: {
                                create: true,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Budget: {
                            actions: {
                                query: true
                            }
                        },
                        ChangeDataCapture: {
                            actions: {
                                changeDataCapture: false
                            }
                        },
                        QBClass: {
                            actions: {
                                create: true,
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        CompanyInfo: {
                            actions: {
                                read: false,
                                query: true
                            }
                        },
                        CreditMemo: {
                            actions: {
                                create: true,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Customer: {
                            actions: {
                                create: true,
                                read: true,
                                update: true,
                                query: true
                            }
                        },
                        Department: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        Deposit: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Employee: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        Estimate: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Invoice: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Item: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        JournalEntry: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Payment: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        PaymentMethod: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        Preferences: {
                            actions: {
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        Purchase: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        PurchaseOrder: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        RefundReceipt: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Reports: {
                            actions: {
                                read: false
                            }
                        },
                        SalesReceipt: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        TaxAgency: {
                            actions: {
                                create: false,
                                read: false,
                                query: true
                            }
                        },
                        TaxCode: {
                            actions: {
                                read: false,
                                query: true
                            }
                        },
                        TaxRate: {
                            actions: {
                                read: false,
                                query: true
                            }
                        },
                        TaxService: {
                            actions: {
                                create: false
                            }
                        },
                        Term: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        TimeActivity: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Transfer: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                        Vendor: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                query: true
                            }
                        },
                        VendorCredit: {
                            actions: {
                                create: false,
                                read: false,
                                update: false,
                                delete: false,
                                query: true
                            }
                        },
                    }
                },
                methods: {
                    openEntity: function(entity) {
                        this.entity = entity;
                        this.activeTab = _.first(Object.keys(this.getEntityActions())) 
                    },
                    openTab: function(type) {
                        this.activeTab = type;
                    },
                    getEntityActions: function() {
                        return this.entities[this.entity].actions;
                    },
                    getEntityAction: function() {
                        return this.entities[this.entity].actions[this.activeTab];
                    },
                    getTabClass: function(type) {
                        return [type == this.activeTab ? 'active' : ''];
                    },
                    getMenuClass: function(type) {
                        return [type == this.entity ? 'active' : ''];
                    },
                    read: function() {
                        this.loading = true;
                        this.$http.post('read.php', {id: this.data.id, entity: this.entity}, {emulateJSON: true})
                            .then(function(response) {
                                this.response = JSON.stringify(response.json(), null, 2);
                                this.loading = false;
                            }, function() {
                                this.response = 'Failed to fetch data.';
                                this.loading = false;
                            });
                    },
                    query: function() {
                        this.loading = true;
                        this.$http.post('query.php', {max_results: this.data.max_results, entity: this.entity}, {emulateJSON: true})
                            .then(function(response) {
                                this.response = JSON.stringify(response.json(), null, 2);
                                this.loading = false;
                            }, function() {
                                this.response = 'Failed to fetch data.';
                                this.loading = false;
                            });
                    }
                },
                computed: {
                }
            });
        </script>
    </body>
</html>