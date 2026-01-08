import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";
import { Info } from "lucide-react";
import Select, { components, OptionProps } from "react-select";
import FormError from "./FormError";

const Option = (props: OptionProps<any>) => {
    return (
        <components.Option { ...props }>
            <span className="font-semibold">{ props.data.label }</span>
            <br />
            <span className="text-xs">{ `e.g. ${props.data.example}` }</span>
        </components.Option>
    );
};

export default function QuarantinePrimaryFaultClassificationField({ error }: {
    error?: string;
}) {
    const classifications = usePage<SharedData>().props.fault_classifications as {
        value: string;
        label: string;
        example: string;
    }[];

    return (
        <div className="card bg-base-100 shadow-sm">
            <div className="card-body">
                <div className="space-y-4">
                    <label className="block font-semibold">{ 'Primary fault classification' }</label>
                    <div className="flex items-start gap-1 mt-2">
                        <Info size={ 16 } className="text-secondary shrink-0" />
                        <p className="text-xs">{ 'Classify the type of primary fault with this Product (that is, if a Product has multiple reasons for submission to Quarantine, which is the most prominent / serious?)' }</p>
                    </div>
                    <Select
                        options={ classifications }
                        name="classification"
                        isSearchable
                        placeholder={ 'Select an option' }
                        components={ { Option } }
                    />
                </div>
                { error && <FormError message={ error } /> }
            </div>
        </div>
    );
}
