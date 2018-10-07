                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" v-html="type">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li  v-for="cat in rows.sonCat">
                                <a  v-on:click="reGetList(cat.id,cat.cat_name)">@{{cat.cat_name}}</a>
                            </li>
                        </ul>
