<div id="search-zone">
    <h2>{@main.search@}</h2>
    {form $form, $submitAction, array('search' => true)}
        <div>
            {ctrl_label 'types'}
            {ctrl_control 'types'}
        </div>
        {formcontrols}
        <div>
           {ctrl_label}{ctrl_control}
        </div>
        {/formcontrols}
        <div>
        {formsubmit}
        </div>
    {/form}
</div>
