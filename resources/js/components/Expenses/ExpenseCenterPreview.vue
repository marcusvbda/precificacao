<template>
    <tr>
        <td colspan="2">
            <div class="row mb-3" v-for="(row,i) in selected_options" :key="i" v-loading="loading"
                element-loading-text="Carregando ...">
                <div class="col-12">
                    <h4 class='mb-2'>{{row.name}}</h4>
                    <div class="mb-4" v-if="row.expenses.length <= 0">
                        <small class="text-muted">Centro de custo sem despesas relacionadas</small>
                    </div>
                    <table v-else class="table table-striped table-sm mb-4">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(expense,i) in row.expenses" :key="i">
                                <th scope="row">{{expense.name}}</th>
                                <td>{{expense.f_type}}</td>
                                <td>{{expense.f_value}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6 col-sm-12">
                    <VueApexCharts type="treemap" v-if="visible" height="500" width="500" :options="chartOptions"
                        :series="series" />
                </div>
                <div class="d-flex justify-content-start align-items-end col-md-6 col-sm-12 flex-column">
                    <h4><b class="mr-2">Preço calculado : </b>{{computed_price.currency()}}</h4>
                    <h4><b class="mr-2 text-success">Preço sugerido : </b>{{suggested_price.currency()}}</h4>
                </div>
            </div>
        </td>
    </tr>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    props: ["form"],
    data() {
        return {
            loading: true,
            timeout: null,
            options: [],
            chartOptions: {
                download: false,
                legend: {
                    show: true
                },
                chart: {
                    type: 'treemap'
                },
                title: {
                    text: 'Gráfico de proporção'
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                    },
                    offsetY: -4
                }
            },
        }
    },
    components: {
        VueApexCharts
    },
    computed: {
        series() {
            let data = [];
            for (let i in this.selected_options) {
                let options = this.selected_options[i];
                for (let y in options.expenses) {
                    let expense = options.expenses[y];
                    data.push({ x: expense.name, y: expense.value })
                }
            }

            data.push({ x: "Margem", y: this.margin_real_value })
            return [{ data }]
        },
        selected_options() {
            return this.options.filter(x => this.expense_center_ids.includes(parseInt(x.id)) || this.expense_center_ids.includes(String(x.id)))
        },
        expense_center_ids() {
            return this.form?.expense_center_ids ? this.form.expense_center_ids : [];
        },
        visible() {
            return this.expense_center_ids.length > 0;
        },
        margin_real_value() {
            if (this.form.margin_type == "fixed") {
                return Number(this.form.margin);
            } else {
                return (Number(this.form.base_price) * Number(this.form.margin)) / 100;
            }
        },
        suggested_price() {
            let price = Number(this.computed_price);
            price += this.margin_real_value;
            return (isNaN(price) ? 0 : price);
        },
        computed_price() {
            let price = Number(this.form.base_price);
            for (let i in this.selected_options) {
                let options = this.selected_options[i];
                for (let y in options.expenses) {
                    let expense = options.expenses[y];
                    if (expense.type == "fixed") {
                        price += Number(expense.value);
                    } else {
                        price += (Number(this.form.base_price) * Number(expense.value)) / 100;
                    }
                }
            }
            return (isNaN(price) ? 0 : price);
        }
    },
    watch: {
        visible(val) {
            if (val) {
                this.loadContent();
            } else {
                this.options = []
            }
        }
    },
    created() {
        if (this.visible) {
            this.loading = true;
            this.options = [];
            this.getContent();
        }
    },
    methods: {
        loadContent() {
            this.loading = true;
            this.options = [];
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.getContent();
            }, 1500);
        },
        getContent() {
            this.$http
                .post("/vstack/json-api", {
                    model: "\\App\\Http\\Models\\ExpenseCenter",
                    filters: {
                        where_in: [["id", this.expense_center_ids]]
                    },
                    includes: ["expenses"]
                })
                .then(({ data }) => {
                    this.options = data;
                    this.loading = false;
                });
        }
    }
}
</script>