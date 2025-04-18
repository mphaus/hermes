export default function ProductionAdministratorsIndex () {
    return {
        fetching: false,
        fetched: false,
        productionAdministrators: [],
        errorMessage: '',
        init () {
            this.fetchData();
        },
        async fetchData () {
            this.fetching = true;
            this.productionAdministrators = [];
            this.errorMessage = '';

            try {
                const response = await window.axios.get( route( 'production-administrators.index' ) );

                /**
                 * @type {{production_administrators: array}}
                 */
                const { production_administrators } = response.data;
                this.productionAdministrators = [ ...production_administrators ];
            } catch ( error ) {
                console.log( error );

                const { error_message } = error.response.data;
                this.errorMessage = error_message;
            } finally {
                this.fetching = false;
                this.fetched = true;
            }
        },
        get hasFetched () {
            return this.fetched && !this.fetching && this.errorMessage === '';
        },
    };
}
