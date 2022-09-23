<template>
    <tr v-if="visible" v-loading="loading" element-loading-text="Carregando ...">
        <td colspan="2">
            <table class="table table-striped  table-sm">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(expense,i) in options" :key="i">
                        <th scope="row">{{expense.name}}</th>
                        <td>{{expense.f_type}}</td>
                        <td>{{expense.f_value}}</td>
                    </tr>
                </tbody>
            </table>
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
            options: []
        }
    },
    computed: {
        expense_ids() {
            return this.form?.expense_ids ? this.form.expense_ids : [];
        },
        visible() {
            return this.expense_ids.length;
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
                    model: "\\App\\Http\\Models\\Expense",
                    filters: {
                        where_in: [["id", this.expense_ids]]
                    }
                })
                .then(({ data }) => {
                    this.options = data;
                    this.loading = false;
                });
        }
    }
}
</script>