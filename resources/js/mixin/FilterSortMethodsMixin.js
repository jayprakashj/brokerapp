export default {
    methods:{
        applySort( column ){
            if( this.sortColumn == column ){
                if( this.sortOrder == 'asc'){
                    this.sortOrder = 'desc';
                }else{
                    this.sortOrder = 'asc';

                }
            }else{
                this.sortColumn = column;
                this.sortOrder = 'asc';
            }

            this.page = 1;
            this.loadListsData();
        },
        applyFilter(){
            this.resetAndLoadList();
        },
        resetAndLoadList(){
            this.page = 1;
            this.loadListsData();

        }
    },
}
