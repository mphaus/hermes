const initialForm = {
    short_job_or_project_name: '',
    object_type: 'opportunity',
    object_id: 0,
};

export default function DiscussionForm () {
    return {
        form: { ...initialForm },
    };
}
