import.meta.glob( [
    './../images/**',
] );

import { Livewire, Alpine } from "./../../vendor/livewire/livewire/dist/livewire.esm";
import ActionStreamFilters from "./components/ActionStreamFilters";
import ItemsCreateForm from "./components/ItemsCreateForm";
import Qet from "./components/Qet";
import UploadLog from "./components/UploadLog";

Alpine.data( 'ActionStreamFilters', ActionStreamFilters );
Alpine.data( 'ItemsCreateForm', ItemsCreateForm );
Alpine.data( 'Qet', Qet );
Alpine.data( 'UploadLog', UploadLog );

Livewire.start();
