import "./bootstrap";
import.meta.glob( [
    './../images/**',
] );

import { Livewire, Alpine } from "./../../vendor/livewire/livewire/dist/livewire.esm";
import ActionStreamFilters from "./components/ActionStreamFilters";
import ActionStreamItem from "./components/ActionStreamItem";
import CreateDiscussionsObject from "./components/CreateDiscussionsObject";
import CreateDiscussionsOwner from "./components/CreateDiscussionsOwner";
import ItemsCreateForm from "./components/ItemsCreateForm";
import Qet from "./components/Qet";
import QetItem from "./components/QetItem";
import UploadLog from "./components/UploadLog";
import UserForm from "./components/UserForm";
import UserDeleteButton from "./components/UserDeleteButton";
import ResetPasswordForm from "./components/ResetPasswordForm";
import SideMenu from "./components/SideMenu";
import QuarantineIntakeObject from "./components/QuarantineIntakeObject";
import QuarantineIntakeProduct from "./components/QuarantineIntakeProduct";

Alpine.data( 'ActionStreamFilters', ActionStreamFilters );
Alpine.data( 'ActionStreamItem', ActionStreamItem );
Alpine.data( 'CreateDiscussionsObject', CreateDiscussionsObject );
Alpine.data( 'CreateDiscussionsOwner', CreateDiscussionsOwner );
Alpine.data( 'ItemsCreateForm', ItemsCreateForm );
Alpine.data( 'Qet', Qet );
Alpine.data( 'QetItem', QetItem );
Alpine.data( 'UploadLog', UploadLog );
Alpine.data( 'UserForm', UserForm );
Alpine.data( 'UserDeleteButton', UserDeleteButton );
Alpine.data( 'ResetPasswordForm', ResetPasswordForm );
Alpine.data( 'SideMenu', SideMenu );
Alpine.data( 'QuarantineIntakeObject', QuarantineIntakeObject );
Alpine.data( 'QuarantineIntakeProduct', QuarantineIntakeProduct );

Livewire.start();
