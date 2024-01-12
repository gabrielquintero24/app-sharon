<script>
export default {
    methods: {
        $relationTableModista(selector) {
            switch (selector) {
                case "tipo_modista_id":
                    return "enum_tipo_modista.name";
                default:
                    return selector;
            }
        },
        $relationTableCorte(selector) {
            switch (selector) {
                default:
                    return selector;
            }
        },
    },
};
</script>
