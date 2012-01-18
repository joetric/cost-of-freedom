from django.db import models

class Place(models.Model):
    state = models.TextField(blank=True, default='')
    vid_req = models.TextField(blank=True, default='')
    bc_req = models.TextField(blank=True, default='')
    county = models.TextField(blank=True, default='')
    vid_agency = models.TextField(blank=True, default='')
    vid_loc = models.TextField(blank=True, default='')
    vid_hours = models.TextField(blank=True, default='')
    vid_phone = models.TextField(blank=True, default='')
    bc_mail_inst= models.TextField(blank=True, default='')
    bc_online_inst = models.TextField(blank=True, default='')
    bc_in_person_agency = models.TextField(blank=True, default='')
    bc_in_person_cost = models.TextField(blank=True, default='')
    bc_in_person_loc = models.TextField(blank=True, default='')
    bc_in_person_hours = models.TextField(blank=True, default='')
    bc_in_person_phone = models.TextField(blank=True, default='')

    def __unicode__(self):
        return '%d %s %s' % (self.id, self.state, self.county)
