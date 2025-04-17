export default function ProductionAdministratorsIndex () {
    return {
        fetching: false,
        productionAdministrators: [],
        init () {
            this.fetchData();
        },
        async fetchData () {
            this.fetching = true;

            try {
                const response = await window.axios.get( route( 'production-administrators.index' ) );
                console.log( response );
            } catch ( error ) {
                console.error( error );
            } finally {
                this.fetching = false;
            }
        }
    };
}
