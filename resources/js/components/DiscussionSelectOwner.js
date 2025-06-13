export default function DiscussionSelectOwner () {
    return {
        fetching: false,
        fetched: false,
        members: [],
        errorMessage: '',
        init () {
            this.fetchData();
        },
        async fetchData () {
            this.fetching = true;
            this.members = [];
            this.errorMessage = '';

            try {
                const response = await window.axios.get( route( 'members.search' ), {
                    params: {
                        'per_page': 25,
                        'filtermode': 'user',
                        'q[active_eq]': true,
                    },
                } );

                this.members = [ ...response.data ];
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
