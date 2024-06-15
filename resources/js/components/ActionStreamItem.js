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
            axios.get( route( 'opportunities.show', [ jobId ] ) )
                .then( res => this.jobName = res.data.subject )
                .catch( () => this.jobName = 'An error occurred while loading the Job name' );
        }
    };
}
