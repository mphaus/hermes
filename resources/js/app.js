import "./bootstrap";
import.meta.glob( [
    './../images/**',
] );

import { Livewire, Alpine } from "./../../vendor/livewire/livewire/dist/livewire.esm";
import ActionStreamFilters from "./components/ActionStreamFilters";
import ActionStreamItem from "./components/ActionStreamItem";
import CreateDiscussionsOpportunity from "./components/CreateDiscussionsOpportunity";
import CreateDiscussionsOwner from "./components/CreateDiscussionsOwner";
import ItemsCreateForm from "./components/ItemsCreateForm";
import Qet from "./components/Qet";
import QetItem from "./components/QetItem";
import UploadLog from "./components/UploadLog";
import UserForm from "./components/UserForm";

Alpine.data( 'ActionStreamFilters', ActionStreamFilters );
Alpine.data( 'ActionStreamItem', ActionStreamItem );
Alpine.data( 'CreateDiscussionsOpportunity', CreateDiscussionsOpportunity );
Alpine.data( 'CreateDiscussionsOwner', CreateDiscussionsOwner );
Alpine.data( 'ItemsCreateForm', ItemsCreateForm );
Alpine.data( 'Qet', Qet );
Alpine.data( 'QetItem', QetItem );
Alpine.data( 'UploadLog', UploadLog );
Alpine.data( 'UserForm', UserForm );

Livewire.start();
