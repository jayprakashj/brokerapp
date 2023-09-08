<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex">
        <div class="p-4 sm:p-5 w-full">

            <div class="">
                <div class=" grid grid-cols-12 gap-2">
                    <div
                        class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData.name ?? 'N/A' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/property"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </router-link>
                            <router-link :to="'/property/edit/' + formData.id"
                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROPERTY ] )"
                            class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa fa-pencil mr-2"></i> Edit
                        </router-link>
                        </div>
                    </div>
                    <div class="card mt-2 p-4 sm:p-5 col-span-8">
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block" >
                                <span>Name</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Building Name</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.building_name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Unit No.</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.unit_no }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Company Branch</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.company_branch_data?.name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Property Type</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_type }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Property Transaction</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_transaction }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Property Furnishing</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_furnishing }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Property Facing</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_facing }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Suitable For</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.suitable_for }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block col-span-2">
                                <span>Address</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.address }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>City</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.city }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Locality</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.locality }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-4 gap-4 sm:grid-cols-4 items-center">
                            <label class="block" >
                                <span>Bedrooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.bedrooms }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Master Bedrooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.master_bedrooms }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Guest Rooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.guest_room }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Child Bedrooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.child_room }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Other Rooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.other_room }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                            <label class="block" >
                                <span>Bathrooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.bathrooms }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Common Bathrooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.common_bathrooms }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Ensult Bathrooms</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.ensult_bathrooms }}
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-4 gap-4 sm:grid-cols-4 items-center">

                            <label class="block" >
                                <span>Sellable Area</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.sellable_area }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Builtup Area</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.builtup_area }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Carpet Area</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.carpet_area }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Plot Area</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.plot_area }}
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                            <label class="block" >
                                <span>Price</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <i class="fa fa-inr"></i> {{ formData.price }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Negotiable Amount</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <i class="fa fa-inr"></i> {{ formData.negotiable_amount }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Security Deposit</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <i class="fa fa-inr"></i> {{ formData.security_deposit }}
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                            <label class="block" >
                                <span>Property Floor</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_floor }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Total Floor</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.total_floor }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>No of Parking</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.no_of_parking }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>No of Lift</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.no_of_lift }}
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                            <label class="block" >
                                <span>Lease Period</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.lease_period }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Lease Expiry Date</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.lease_expiry_date }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Availability</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.availability }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Ownership</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.ownership }}
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                            <label class="block" >
                                <span>Property Obligation</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_obligation }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Age of Property</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.age_of_property }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Workstation</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.workstation }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Conference Room</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.conference_room }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Reception</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.reception }}
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                            <label class="block col-span-12" >
                                <span>Walk Through Link</span>
                                <div class="w-full" v-if="formData.walk_through_link">
                                    <iframe :src="formData.walk_through_link" frameborder="0"></iframe>
                                </div>
                                <p v-else class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    Not Available
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                            <label class="block col-span-6 mt-2">
                                <span>Amenities</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre>{{ formData.amenities }}</pre>
                                </p>
                            </label>
                            <label class="block col-span-6 mt-2">
                                <span>Unique Feature</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre>{{ formData.unique_feature }}</pre>
                                </p>
                            </label>

                        </div>
                    </div>
                    <div class="card mt-2 p-4 sm:p-5 col-span-4">

                        <!-- <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div> -->
                        <div class="  items-center">


                            <label class="block col-span-6 mt-2">
                                <span>Is Verified?</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.is_verified ? 'Yes' : 'No' }}
                                </p>
                            </label>

                            <label class="block col-span-6 mt-2">
                                <span>Is Document Verified?</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.is_document_verified ? 'Yes' : 'No' }}
                                </p>
                            </label>
                            <label class="block col-span-6 mt-2">
                                <span>Assign To</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.assign_user_data?.name || 'N/A' }}
                                </p>
                            </label>

                            <label class="block col-span-6 mt-2">
                                <span>Description</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre>{{ formData.description }}</pre>
                                </p>
                            </label>
                            <label class="block col-span-6 mt-2">
                                <span>Remark</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre>{{ formData.remark }}</pre>
                                </p>
                            </label>
                            <label class="block col-span-6 mt-2">
                                <span>Internal Note</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre>{{ formData.internal_note }}</pre>
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="space-y-4">
                            <label class="block" >
                                <span>Owner Name</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.owner_name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Owner Phone</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.owner_phone }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Owner Email</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.owner_email }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="space-y-4">
                            <label class="block" >
                                <span>Refer By Name</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.refer_by_name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Refer By Phone</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.refer_by_phone }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Refer By Email</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.refer_by_email }}
                                </p>
                            </label>
                        </div>
                    </div>
                    <div class="card mt-2 p-4 sm:p-5 col-span-12" >
                        <div
                            class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Images
                                <button
                                    type="button"
                                    class="btn h-9 w-9 rounded-full bg-info/10 p-0 font-medium text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25"
                                    @click="openModal"
                                >
                                   <i class="fa fa-external-link"></i>
                                </button>
                            </h2>
                        </div>
                        <div class="grid grid-cols-8 gap-4 mt-2">
                            <div class="card" v-for="(imgData, index) in formData.images" :key="'image_list_container_' + index">
                                <img class="w-full rounded-lg object-cover" :src="(imgData.url || 'https://picsum.photos/100/100')" alt="image">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <Teleport to="#teleport-target" v-if="show.modal">

            <property-image-modal-vue v-if="show.modal" :images="formData.images" @close="closeModal"/>
        </Teleport>

    </div>

</template>

<script>
import Swiper from 'swiper'
import {Navigation} from 'swiper/modules'
import { mapGetters } from 'vuex' ;
import PropertyImageModalVue from './PropertyImageModal.vue';
export default {
    components:{
        PropertyImageModalVue
    },
    data(){
        return {
            pageTitle: 'Property Management',
            subTitle: 'View Property',
            isShowPopper: false,
            formData:{
                name: '',
                building_name: null,
                unit_no: null,
                company_branch: null,
                assign_to: null,
                property_type: null,
                property_transaction: null,
                property_furnishing: null,
                is_verified: 0,
                is_document_verified: 0,
                address: null,
                city: null,
                locality: null,
                description: null,
                remark: null,
                internal_note: null,
                unique_feature: null,
                suitable_for: null,
                bedrooms: null,
                master_bedrooms: null,
                guest_room: null,
                child_room: null,
                other_room: null,
                bathrooms: null,
                common_bathrooms: null,
                ensult_bathrooms: null,
                sellable_area: null,
                builtup_area: null,
                carpet_area: null,
                plot_area: null,
                terrace_area: null,
                area_range: null,
                price: null,
                negotiable_amount: null,
                security_deposit: null,
                property_floor: null,
                total_floor: null,
                property_facing: null,
                lease_period: null,
                lease_expiry_date: null,
                availability: null,
                ownership: null,
                no_of_parking: null,
                no_of_lift: null,
                property_obligation: null,
                age_of_property: null,
                workstation: null,
                conference_room: null,
                reception: null,
                walk_through_link: null,
                amenities: null,
                owner_name: null,
                owner_email: null,
                owner_phone: null,
                refer_by_name: null,
                refer_by_email: null,
                refer_by_phone: null,
                images: {}
            },
            show:{
                modal: false
            }
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
        breadcrumbs(){

            var breadcrumbs = [
                        {
                            title: 'Property Management',
                            link: '/property'
                        },
                        {
                            title: 'View',
                        }
                    ];
            return breadcrumbs;
        },

        formDataImagesKeys () {
            return Object.keys( this.formData.images );
        }
    },
    methods:{
        init () {
            if( this.$route?.params?.id ){
                this.loadEditFormDetail( this.$route.params.id );

            }
        },
        loadEditFormDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getPropertyViewDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    setTimeout(() => {

                                        this.$nextTick( () => {
                                            new Swiper( this.$refs['swiper'],{
                                                modules:[ Navigation ],
                                                    navigation: {
                                                        prevEl: this.$refs['swiperPrevBtn'],
                                                        nextEl: this.$refs['swiperNextBtn']}
                                                    }
                                                )
                                        }, 500)
                                    })
                                }
                            },
                            (err) => {
                                this.$toast.error('Err! There is something wrong. Please retry.');
                            }
                        ).finally(
                            () => {
                                this.$store.commit('setGlobalLoaderOff');
                            }
                        )
        },
        openModal () {
            this.show.modal = true;
        },
        closeModal () {
            console.log("HEREE");
            this.show.modal = false;
        }
    }
}
</script>

<style>

</style>
