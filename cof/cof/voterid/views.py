# Create your views here.
from django.core import serializers
from django.shortcuts import render_to_response
from django.http import HttpResponse
import json
from models import Place

def _empty_on_none(var):
    if var is None: var = ''    
    return var

def _get_county_state(county_or_state, state):
    county = None    
    if county_or_state is not None:
        if state is None:
            state = county_or_state
        else:
            county = county_or_state
        county_or_state = None
    return county, state

def _get_req(field, county, state):
    """Return a string of requirements to get a document."""
    # try county first
    reqs = Place.objects.filter(county=county, state=state).exclude(**{field:''})
    if len(reqs) > 0: return getattr(reqs[0], field)
    # fallback to state
    reqs = Place.objects.filter(county='', state=state).exclude(**{field:''})
    if len(reqs) > 0: return getattr(reqs[0], field)
    return '' # found nothing

def _get_loc(placetype, county, state):
    """Takes bc_in_person or vid as placetype."""
    def _get_loc_dict(loc):
        return [{
                    'agency': getattr(x, '%s_agency' % placetype),
                    'loc': getattr(x, '%s_loc' % placetype),
                    'hours': getattr(x, '%s_hours' % placetype),
                    'phone': getattr(x, '%s_phone' % placetype),
                }
                for x in loc]
    # county places first
    exclude_kwargs = {'%s_loc' % placetype: ''}
    loc = Place.objects.filter(county=county, state=state).exclude(**exclude_kwargs)
    loc_dict = _get_loc_dict(loc)
    # statewide places second
    loc = Place.objects.filter(county='', state=state).exclude(**exclude_kwargs)
    loc_dict += _get_loc_dict(loc)
    return loc_dict

def index(request, county_or_state=None, state=None):
    county, state = _get_county_state(county_or_state, state)
    if county is None and state is None:
        msg = 'Select your state to see voter ID requirements.'
        return render_to_response("pick_state.html", {"message": msg,})
    elif county is None:
        msg = 'Voter ID Requirements for %s' % state
    else: 
        msg = 'Voter ID Requirements for %s County, %s' % (county, state)

    return render_to_response("vid_req.html", {"message": msg,})

def api(request, county_or_state=None, state=None):
    # determine county and state
    county, state = _get_county_state(county_or_state, state)

    results = {'results':{
        'county': county,
        'state': state,  
        'vid_req': _get_req('vid_req', county, state),
        'vid_locations': _get_loc('vid', county, state),
        'bc_req': _get_req('bc_req', county, state),
        'bc_mail_inst': _get_req('bc_mail_inst', county, state),
        'bc_online_inst': _get_req('bc_online_inst', county, state),
        'bc_in_person_cost': _get_req('bc_in_person_cost', county, state),
        'bc_locations': _get_loc('bc_in_person', county, state),
        }
    }

    jso = json.dumps(results, indent=2) 

    return HttpResponse(jso, mimetype='application/json')
