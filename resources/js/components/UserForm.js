import { normalizeString } from "../utils";

export default function UserForm () {
    return {
        functionAccessDisabled: false,
        /**
         * @param {string} firstName
         * @param {string} lastName
         */
        normalizeUsername ( firstName, lastName ) {
            this.$wire.form.username = normalizeString( firstName, lastName );
        },
        /**
         * @param {boolean} isAdmin 
         */
        toggleFunctionAccess ( isAdmin ) {
            if ( !isAdmin ) {
                this.functionAccessDisabled = false;
                return;
            }

            this.$wire.form.permissions = [];
            this.functionAccessDisabled = true;
        }
    };
}
