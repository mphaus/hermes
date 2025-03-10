const initialForm = {
    opportunity_id: '',
    csv: '',
}

const initialErrors = {
    ...initialForm,
    item_process: '',
};

export default function EquipmentImportForm ( initialOpportunityId ) {
    return {
        submitting: false,
        opportunityId: initialOpportunityId,
        form: {
            ...initialForm,
            opportunity_id: initialOpportunityId,
        },
        errors: { ...initialErrors },
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

            this.errors = { ...initialErrors };
            this.submitting = true;

            const formData = new FormData();
            formData.append( 'opportunity_id', this.form.opportunity_id );
            formData.append( 'csv', this.form.csv );

            try {
                const response = await window.axios.post( this.$root.action, formData );
            } catch ( error ) {
                console.log( error );

            } finally {
                this.submitting = false;
            }
        },
    }
}
