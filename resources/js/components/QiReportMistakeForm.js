import axios from "axios";

export default function QiReportMistakeForm () {
    return {
        submitting: false,
        remainingCharacters: 512,
        form: {
            message: '',
        },
        errors: {
            message: '',
        },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.submitting = true;

            try {
                const response = await axios.post( this.$root.action, this.form );
                console.log( response.data );
            } catch ( error ) {
                debugger;
                // console.error( error );
            }

            this.submitting = false;
        },
    };
}
