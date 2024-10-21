export default function ResetPasswordForm () {
    const passwordPattern = /^(?=.*[A-Z].*[A-Z])(?=.*[a-z].*[a-z])(?=.*\d.*\d)(?=.*[!@#$%^&*()\-_+=].*[!@#$%^&*()\-_+=]).{12,24}$/;
    const lengthPattern = /.{12,24}/;
    const twoUppercaseLettersPattern = /(?=.*[A-Z].*[A-Z])/g;
    const twoLowercaseLettersPattern = /(?=.*[a-z].*[a-z])/g;
    const twoNumbersPattern = /(?=.*\d.*\d)/g;
    const twoSpecialCharactersPattern = /(?=.*[!@#$%^&*()\-_+=].*[!@#$%^&*()\-_+=])/g;

    return {
        password: '',
        passwordConfirm: '',
        get passwordsMatch () {
            return this.password !== '' && this.password === this.passwordConfirm;
        },
        get submitDisabled () {
            return this.passwordsMatch === false || passwordPattern.test( this.password ) === false;
        },
        get hasCorrectLength () {
            return this.passwordsMatch && lengthPattern.test( this.password );
        },
        get hasTwoUppercaseLetters () {
            return this.passwordsMatch && twoUppercaseLettersPattern.test( this.password );
        },
        get hasTwoLowercaseLetters () {
            return this.passwordsMatch && twoLowercaseLettersPattern.test( this.password );
        },
        get hasTwoNumbers () {
            return this.passwordsMatch && twoNumbersPattern.test( this.password );
        },
        get hasTwoSpecialCharacters () {
            return this.passwordsMatch && twoSpecialCharactersPattern.test( this.password );
        },
    };
}
