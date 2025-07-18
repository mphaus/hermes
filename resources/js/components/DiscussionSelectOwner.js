export default function DiscussionSelectOwner () {
    return {
        value: '',
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
                this.$nextTick( () => this.initSelect2() );
            } catch ( error ) {
                console.log( error );

                const { message } = error.response.data;
                this.errorMessage = message;
            } finally {
                this.fetching = false;
                this.fetched = true;
            }
        },
        get hasFetched () {
            return this.fetched && !this.fetching && this.errorMessage === '';
        },
        initSelect2 () {
            $( this.$refs.ownerSelectElement )
                .select2( {
                    placeholder: 'Select an Account Manager',
                    width: '100%',
                } )
                .on( 'change.select2', () => {
                    const value = Number( $( this.$refs.ownerSelectElement ).val() );

                    if ( !value ) {
                        return;
                    }

                    this.value = value;
                    const { id, name } = { ...this.members.find( member => member.id === value ) };
                    this.$dispatch( 'hermes:discussion-select-owner-change', {
                        owner: { id, name },
                    } );
                } );
        },
    };
}
