import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";
import { useCharacterLimit } from "@/hooks";
import { useRef } from "react";
import clsx from "clsx";
import { Quarantine } from "@/pages/QuarantineSuccess";
import FormError from "./FormError";
import QuarantineReportMistakeController from "@/actions/App/Http/Controllers/QuarantineReportMistakeController";

export default function QuarantineReportMistakeForm({ quarantine }: {
    quarantine: Quarantine;
}) {

    const MAX = 512;
    const textareaRef = useRef<HTMLTextAreaElement>(null);
    const { remaining, isOverLimit, handleLimitChange } = useCharacterLimit(MAX);

    return (
        <Form
            action={QuarantineReportMistakeController()}
            className="space-y-4"
            options={{
                preserveScroll: true,
            }}
        >
            {({
                errors,
                hasErrors,
                processing,
            }) => (
                <>
                    {hasErrors && (
                        <div role="alert" className="alert alert-error">
                            <span>{'Some fields need your attention. Please review the form and correct the highlighted errors.'}</span>
                        </div>
                    )}
                    <input type="hidden" name="submitted" value={quarantine.formatted_created_at} />
                    <input type="hidden" name="quarantine_id" value={quarantine.id} />
                    <input type="hidden" name="job" value={quarantine.custom_fields.opportunity} />
                    <input type="hidden" name="product" value={quarantine.name} />
                    <input type="hidden" name="serial" value={quarantine.reference} />
                    <input type="hidden" name="ready_for_repairs" value={quarantine.formatted_starts_at} />
                    <input type="hidden" name="primary_fault_classification" value={quarantine.primary_fault_classification} />
                    <input type="hidden" name="fault_description" value={quarantine.description} />
                    <input type="hidden" name="intake_location" value={quarantine.custom_fields.intake_location} />
                    <FormGroup>
                        <label htmlFor="message" className="sr-only">{'Message'}</label>
                        <textarea
                            name="message"
                            id="message"
                            className="textarea"
                            rows={4}
                            ref={textareaRef}
                            onChange={() => handleLimitChange(textareaRef?.current?.value ?? "")}
                        />
                        {errors.message && <FormError message={errors.message} />}
                        <p className={clsx({
                            'text-xs font-semibold mt-1': true,
                            'text-error': isOverLimit,
                        })}>
                            {remaining} {remaining === 1 ? 'character' : 'characters'} left
                        </p>
                    </FormGroup>
                    <div className="flex justify-end">
                        <button
                            type="submit"
                            className="btn btn-primary"
                            disabled={processing}
                        >
                            {processing ? 'Sending...' : 'Send'}
                        </button>
                    </div>
                </>
            )}
        </Form>
    );
}