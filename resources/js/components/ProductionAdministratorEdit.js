/**
 * @param {int} id 
 */
export default function ProductionAdministratorEdit ( id ) {
    return {
        fetching: false,
        productionAdministrator: {},
        errorMessage: '',
        init () {
            this.fetchData();
        },
        async fetchData () {
            this.fetching = true;
            this.productionAdministrator = {};
            this.errorMessage = '';

            try {
                const response = await window.axios.get( route( 'production-administrators.show', id ) );

                /**
                 * @type {{production_administrator: object}}
                 */
                const { production_administrator } = response.data;
                this.productionAdministrator = { ...production_administrator };
            } catch ( error ) {
                console.log( error );

                const { error_message } = error.response.data;
                this.errorMessage = error_message;
            } finally {
                this.fetching = false;
            }
        }
    };
}
