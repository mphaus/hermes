export default function TechnicalSupervisorsIndex () {
    return {
        fetching: false,
        fetched: false,
        technicalSupervisors: [],
        errorMessage: '',
        init () {
            this.fetchData();
        },
        async fetchData () {
            this.fetching = true;
            this.technicalSupervisors = [];
            this.errorMessage = '';

            try {
                const response = await window.axios.get( route( 'technical-supervisors.index' ) );

                /**
                 * @type {{technical_supervisors: array}}
                 */
                const { technical_supervisors } = response.data;
                this.technicalSupervisors = [ ...technical_supervisors ];
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
