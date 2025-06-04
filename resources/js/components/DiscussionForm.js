const initialForm = {
    short_job_or_project_name: '',
    entity_type: 'opportunity',
};

export default function DiscussionForm () {
    return {
        form: { ...initialForm },
    };
}
