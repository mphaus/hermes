/**
 * @param {number} id
 */
export default function TechnicalSupervisorEdit ( id ) {
    return {
        fetching: false,
        technicalSupervisor: {},
        errorMessage: '',
        init () {
            this.fetchData();
        },
        async fetchData () {
            this.fetching = true;
            this.technicalSupervisor = {};
            this.errorMessage = '';

            try {
                const response = await window.axios.get( route( 'technical-supervisors.show', id ) );

                /**
                 * @type {{technical_supervisor: object}}
                 */
                const { technical_supervisor } = response.data;
                this.technicalSupervisor = { ...technical_supervisor };
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
