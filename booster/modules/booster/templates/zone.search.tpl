<div id="search-zone" class="booster_menu container_16">
    <h2>{@main.search@}</h2>

    {form $form, $submitAction, array('search' => true)}
        <div>
            {ctrl_label 'types'}
            {ctrl_control 'types'}
        </div>

        <div>
            {formcontrols}
           <span>{ctrl_label}{ctrl_control}</span>
            {/formcontrols}
        </div>

        <div>
            {formsubmit}
        </div>
    {/form}


</div>
