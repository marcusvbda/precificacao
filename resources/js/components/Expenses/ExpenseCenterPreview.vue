<template>
    <tr>
        <td colspan="2">
            <div class="row mb-3" v-for="(row,i) in options" :key="i" v-if="visible" v-loading="loading"
                element-loading-text="Carregando ...">
                <div class="col-12">
                    <h4 class='mb-3'>{{row.name}}</h4>
                    <table class="table table-striped  table-sm">
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
                <div class="d-flex justify-content-end align-items-end col-12 flex-column">
                    <h4><b class="mr-2">Preço calculado : </b>{{computed_price.currency()}}</h4>
                    <h4><b class="mr-2 text-success">Preço sugerido : </b>{{suggested_price.currency()}}</h4>
                </div>
            </div>
        </td>
    </tr>
</template>
<script>

export default {
    props: ["form"],
    data() {
        return {
            loading: true,
            timeout: null,
            options: [],
        }
    },
    computed: {
        expense_center_ids() {
            return this.form?.expense_center_ids ? this.form.expense_center_ids : [];
        },
        visible() {
            return this.expense_center_ids.length;
        },
        suggested_price() {
            let price = Number(this.computed_price);
            if (this.form.margin_type == "fixed") {
                price += Number(this.form.margin);
            } else {
                price += (this.form.base_price * this.form.margin) / 100;
            }
            return (isNaN(price) ? 0 : price);
        },
        computed_price() {
            let price = this.form.base_price;
            for (let i in this.options) {
                let options = this.options[i];
                for (let y in options.expenses) {
                    let expense = options.expenses[y];
                    if (expense.type == "fixed") {
                        price -= expense.value;
                    } else {
                        price -= (this.form.base_price * expense.value) / 100;
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