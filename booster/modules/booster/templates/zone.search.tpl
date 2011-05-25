<div id="search-zone">
    <h2>{@main.search@}</h2>
    {form $form, $submitAction, array('search' => true)}
        <div>
            {ctrl_label 'types'}
            {ctrl_control 'types'}
        </div>
        <div>
            {formcontrols}
           <p>{ctrl_label}{ctrl_control}</p>
            {/formcontrols}
        </div>
        <div>
            {formsubmit}
        </div>
    {/form}
</div>
