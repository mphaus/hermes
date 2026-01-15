import { StylesConfig } from "react-select";

/**
 * Shared styles for react-select components to match daisyUI's select.select.appearance-none styling
 * Uses CSS custom properties that daisyUI provides via Tailwind CSS
 */
export const daisyUISelectStyles: StylesConfig<any, false> = {
    control: (base, state) => ({
        ...base,
        backgroundColor: "var(--color-base-100)",
        borderColor: state.isFocused
            ? "var(--input-color)"
            : "color-mix(in srgb, var(--color-base-content) 20%, transparent)",
        borderWidth: state.isFocused ? "2px" : "1px",
        borderRadius: "var(--radius-field, 0.5rem)",
        minHeight: "40px",
        boxShadow: state.isFocused
            ? "0 0 0 2px color-mix(in srgb, var(--input-color) 20%, transparent)"
            : "none",
        "&:hover": {
            borderColor: state.isFocused ? "var(--input-color)" : "color-mix(in srgb, var(--color-base-content) 30%, transparent)",
        },
    }),
    placeholder: (base) => ({
        ...base,
        color: "color-mix(in srgb, var(--color-base-content) 50%, transparent)",
    }),
    singleValue: (base) => ({
        ...base,
        color: "var(--color-base-content)",
    }),
    input: (base) => ({
        ...base,
        color: "var(--color-base-content)",
    }),
    menu: (base) => ({
        ...base,
        backgroundColor: "var(--color-base-100)",
        borderRadius: "var(--radius-box, 0.5rem)",
        border: "1px solid color-mix(in srgb, var(--color-base-content) 20%, transparent)",
        boxShadow: "0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)",
        marginTop: "0.25rem",
    }),
    option: (base, state) => ({
        ...base,
        backgroundColor: state.isSelected
            ? "var(--color-base-300)"
            : state.isFocused
                ? "var(--color-base-200)"
                : "transparent",
        color: state.isSelected
            ? "var(--color-base-content)"
            : "var(--color-base-content)",
        "&:active": {
            backgroundColor: "var(--color-base-300)",
        },
    }),
    indicatorSeparator: (base) => ({
        ...base,
        backgroundColor: "color-mix(in srgb, var(--color-base-content) 20%, transparent)",
    }),
    dropdownIndicator: (base, state) => ({
        ...base,
        color: "color-mix(in srgb, var(--color-base-content) 60%, transparent)",
        "&:hover": {
            color: "var(--color-base-content)",
        },
    }),
    clearIndicator: (base) => ({
        ...base,
        color: "color-mix(in srgb, var(--color-base-content) 60%, transparent)",
        "&:hover": {
            color: "var(--color-base-content)",
        },
    }),
    loadingIndicator: (base) => ({
        ...base,
        color: "color-mix(in srgb, var(--color-base-content) 60%, transparent)",
    }),
    multiValue: (base) => ({
        ...base,
        backgroundColor: "color-mix(in srgb, var(--color-primary) 10%, transparent)",
    }),
    multiValueLabel: (base) => ({
        ...base,
        color: "var(--color-base-content)",
    }),
    multiValueRemove: (base) => ({
        ...base,
        color: "color-mix(in srgb, var(--color-base-content) 60%, transparent)",
        "&:hover": {
            backgroundColor: "var(--color-error)",
            color: "var(--color-error-content)",
        },
    }),
};
