export default function ProductionAdministratorsIndex () {
    return {
        fetching: false,
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
                console.log( response );


                const { production_administrators } = response.data;
                this.productionAdministrators = [ ...production_administrators ];
            } catch ( error ) {
                console.error( error );
            } finally {
                this.fetching = false;
            }
        }
    };
}
