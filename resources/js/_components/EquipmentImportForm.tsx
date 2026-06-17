import EquipmentImportStoreController from "@/actions/App/Http/Controllers/EquipmentImportStoreController";
import { Form } from "@inertiajs/react";
import { LoaderCircle } from "lucide-react";
import FormGroup from "./FormGroup";
import FormError from "./FormError";

export default function EquipmentImportForm({ opportunity }: {
    opportunity: Record<string, any>;
}) {
    return (
        <div className="card bg-base-100 shadow-sm">
            <div className="card-body">
                <h2 className="card-title">{'Upload file'}</h2>
                <p>{'Hermes imports a CSV list of equipment (typically rigging and cabling) into the specified CurrentRMS Opportunity, so it can be checked for stock availability and so it will appear on the Picking List.'}</p>
                <p>{'Imported CSV files must be four columns; the CurrentRMS "Item id", the associated CurrentRMS "Item name", the "Quantity", and "Group name". Errors are reported below.'}</p>
                <p>{'Re-uploads for an Opportunity will overwrite previously uploaded CSVs, including changing counts, removing items that were zeroed out, and adding new items that previously had a zero count.'}</p>
                <p>{'Once the upload is complete, items from the CSV will be added to the specified Group, at the bottom of the specified Opportunity.'}</p>
                <Form action={EquipmentImportStoreController()} className="space-y-4 mt-6">
                    {({ processing, errors }) => (
                        <>
                            <input type="hidden" name="opportunity_id" value={opportunity.id} />
                            <label htmlFor="csv_file" className="sr-only">{'CSV file'}</label>
                            <input type="file" name="csv_file" id="csv_file" className="file-input file-input-primary w-full" />
                            {errors.opportunity_id && <FormError message={errors.opportunity_id} />}
                            {errors.csv_file && <FormError message={errors.csv_file} />}
                            <div className="flex justify-end">
                                <button
                                    type="submit"
                                    className="btn btn-primary"
                                    disabled={processing}
                                >
                                    {processing ? (
                                        <>
                                            <LoaderCircle className="animate-spin" size={16} />
                                            <span>{'Processing...'}</span>
                                        </>
                                    ) :
                                        'Upload'
                                    }
                                </button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </div>
    );
}