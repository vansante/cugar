
<!-- TODO: Intro: incoming on interface, not appliance -->

<p>
    <a class="icon_add status_traffic_refresh_link" href="#status_traffic" rel="<?=$this->status_traffic_id?>">Refresh</a>
</p>

<h3>Legend</h3>
<table class="status_traffic_legend" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <th class="status_traffic_legend_in"></th>
            <td>Input (bytes / second)</td>
        </tr>
        <tr>
            <th class="status_traffic_legend_out"></th>
            <td>Output (bytes / second)</td>
        </tr>
    </tbody>
</table>

<h3>Daily graph (5 minute average)</h3>

<div id="status_traffic_<?=$this->status_traffic_id?>_daily"></div>

<h3>Weekly graph (30 minute average)</h3>

<div id="status_traffic_<?=$this->status_traffic_id?>_weekly"></div>

<h3>Monthly graph (2 hour average)</h3>

<div id="status_traffic_<?=$this->status_traffic_id?>_monthly"></div>

<h3>Yearly graph (1 day average)</h3>

<div id="status_traffic_<?=$this->status_traffic_id?>_yearly"></div>

