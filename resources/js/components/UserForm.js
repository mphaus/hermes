import { normalizeString } from "../utils";

export default function UserForm () {
    return {
        first_name: '',
        last_name: '',
        normalizeUsername ( firstName, lastName ) {
            this.$wire.form.username = normalizeString( firstName, lastName );
        }
    };
}
