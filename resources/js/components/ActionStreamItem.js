/**
 * @param {number} jobId
 */
export default function ActionStreamItem ( jobId ) {
    return {
        jobName: 'loading Job name...',
        init () {
            if ( jobId > 0 ) {
                this.getJobName();
            }
        },
        getJobName () {
            const subject = window.sessionStorage.getItem( `action-stream-job-name-${ jobId }` );

            if ( subject !== null ) {
                this.jobName = subject;
                return;
            }

            axios.get( route( 'opportunities.show', [ jobId ] ) )
                .then( res => {
                    /** @type {{ subject: string }} */
                    const { subject } = res.data;
                    window.sessionStorage.setItem( `action-stream-job-name-${ jobId }`, subject );
                    this.jobName = subject;
                } )
                .catch( () => this.jobName = 'An error occurred while loading the Job name' );
        }
    };
}
