import { normalizeString } from "../utils";

export default function UserForm () {
    let permissionItemsCount = 0;
    let canNormalizeUsername = route().current( 'users.edit' ) ? false : true;

    return {
        functionAccessDisabled: false,
        init () {
            permissionItemsCount = this.$refs.permissionsList.querySelectorAll( 'li' ).length;
        },
        /**
         * @param {string} firstName
         * @param {string} lastName
         */
        normalizeUsername ( firstName, lastName ) {
            if ( !canNormalizeUsername ) {
                canNormalizeUsername = true;
                return;
            }

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
        },
        /**
         * @param {number} permissionsCount
         */
        toggleAdmin ( permissionsCount ) {
            if ( permissionsCount !== permissionItemsCount ) {
                return;
            }

            this.$wire.form.permissions = [];
            this.$wire.form.is_admin = true;
        },
    };
}
