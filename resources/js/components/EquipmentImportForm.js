const initialForm = {
    opportunity_id: '',
    csv: '',
}

const initialErrors = {
    ...initialForm,
    item_process: '',
};

export default function EquipmentImportForm ( initialOpportunityId ) {
    const beforeUnloadHandler = ( e ) => {
        e.preventDefault();
        e.returnValue = true;
    };

    return {
        submitting: false,
        opportunityId: initialOpportunityId,
        form: {
            ...initialForm,
            opportunity_id: initialOpportunityId,
        },
        errors: { ...initialErrors },
        alert: {},
        init () {
            this.$watch( 'submitting', isSubmitting => {
                if ( isSubmitting ) {
                    window.addEventListener( 'beforeunload', beforeUnloadHandler );
                } else {
                    window.removeEventListener( 'beforeunload', beforeUnloadHandler );
                }
            } );
        },
        destroy () {
            this.submitting = false;
        },
        /**
         * @param {File | undefined} file
         */
        setFile ( file ) {
            if ( file === undefined ) {
                this.form.csv = '';
                return;
            }

            this.form.csv = file;
        },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.alert = {};
            this.errors = { ...initialErrors };
            this.submitting = true;

            const formData = new FormData();
            formData.append( 'opportunity_id', this.form.opportunity_id );
            formData.append( 'csv', this.form.csv );

            try {
                const response = await window.axios.post( this.$root.action, formData );
                const { redirect_to } = response.data;

                this.submitting = false;
                this.$nextTick( () => window.location = redirect_to );
            } catch ( error ) {
                if ( error.status === 422 ) {
                    const { errors } = error.response.data;

                    for ( const key in errors ) {
                        this.errors[ key ] = errors[ key ][ 0 ];
                    }

                    this.submitting = false;
                    return;
                }

                console.error( error );
                this.submitting = false;
                this.$nextTick( () => this.alert = { ...error.response.data } );
            }
        },
    }
}
